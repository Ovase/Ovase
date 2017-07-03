<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class PersonType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('firstName', TextType::class,array('label'=>'Fornavn',))
            ->add('lastName', TextType::class,array('label'=>'Etternavn',))
			->add('email', EmailType::class,array('label'=>'E-post',))
            ->add('tlf', TextType::class,array('label'=>'Telefonnummer',))
            ->add('location', TextType::class, array('label'=>'Adresse','attr' => array('placeholder' => "Adresse på formen 'gatenavn gatenummer, tettsted'")))
            ->add('competence', TextareaType::class,array('label'=>'Kompetanse',))
            ->add('image', FileType::class, array('label'=>'Last opp bilde av deg','mapped' => false, 'required'=>false))
			->add('save', SubmitType::class, array('label' => 'Lag person'));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Person',
		));
	}
}