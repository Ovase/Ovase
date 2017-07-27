<?php
namespace AppBundle\Form;

use AppBundle\Domain\OvaseDomain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class CompanyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $typeChoices = OvaseDomain::getCompanyTypeChoices();
		$builder
			->add('name', TextType::class,array('label'=>'Navn',))
            ->add('actorTypes', ChoiceType::class, array(
                'label' => 'Type virksomhet',
                'placeholder' => 'Velg en eller flere kategorier',
                'multiple' => true,
                'choices' => $typeChoices,
                'attr' => array(
                    'class' => 'function-select js-example-basic-multiple js-states form-control',
                    'help' => 'Hva gjør din virksomhet?'),
                ))
            ->add('location', TextType::class, array('label'=>'Adresse','attr' => array('placeholder' => "Adresse på formen 'gatenavn gatenummer, tettsted'")))
            ->add('tlf', TextType::class,array('label'=>'Telefonnummer', 'required' => false))
            ->add('homepageUrl', TextType::class,array('label'=>'Hjemmeside', 'required' => false,))
			->add('persons', EntityType::class, array(
				// query choices from this entity
				'label'=>'Tilknyttede personer',
				'class' => 'AppBundle:Person',

				// use the Actor.email property as the visible option string
				'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'required' => false,
				// 'expanded' => true,
				'attr' => array('class'=>'js-example-basic-multiple js-states form-control','help' => 'De personene som er tilknyttet virksomheten. Merk at du bare kan velge brukere som har opprettet person-profil.')
			))
			->add('competence', CKEditorType::class,array('label'=>'Om virksomheten og dens kompetanser', 'required' => false))
			->add('image', FileType::class, array('label'=>'Last opp bilde/logo','mapped' => false, 'required'=>false))
			->add('save', SubmitType::class, array('label' => 'Lagre selskap',));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Company',
		));
	}
}
