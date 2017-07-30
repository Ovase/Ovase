<?php
namespace AppBundle\Form;

use AppBundle\Domain\OvaseDomain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\PurifiedCKEditorType;

class PersonType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $typeChoices = OvaseDomain::getPersonTypeChoices();
		$builder
			->add('firstName', TextType::class,array('label'=>'Fornavn',))
            ->add('lastName', TextType::class,array('label'=>'Etternavn',))
            ->add('workplace', TextType::class,array('label'=>'Arbeidsgiver/skole',))
            ->add('location', TextType::class, array('label'=>'Adresse arbeidssted','attr' => array('placeholder' => "Adresse på formen 'gatenavn gatenummer, tettsted'")))
            ->add('actorTypes', ChoiceType::class, array(
                'label' => 'Yrke/bakgrunn',
                'placeholder' => 'Velg en eller flere kategorier',
                'multiple' => true,
                'choices' => $typeChoices,
                'attr' => array(
                    'class' => 'function-select js-example-basic-multiple js-states form-control',
                    'help' => 'Hva motiverer deg til å lage en person-profil?'),
                ))
			->add('email', EmailType::class,array(
                'label'=>'E-post',
                'required' => false,
                'attr' => array('help' => 'Synlig e-post for de som vil komme i kontakt.')))
            ->add('tlf', TextType::class,array(
                'label'=>'Telefonnummer',
                'required' => false,
                'attr' => array('help' => 'Synlig telefonnummer for de som vil komme i kontakt.')))
            ->add('homepageUrl', TextType::class,array('label'=>'Hjemmeside', 'required' => false,))
            ->add('competence', PurifiedCKEditorType::class,array('label'=>'Kompetanser og interesser', 'required' => false))
            ->add('image', FileType::class, array('label'=>'Last opp bilde av deg','mapped' => false, 'required'=>false))
			->add('save', SubmitType::class, array('label' => 'Lagre person'));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Person',
		));
	}
}