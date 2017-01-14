<?php

// src/AppBundle/Form/EditUserType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditUserType extends AbstractType
{
	// Seperate form for editing user information. ONLY to be used by editors.
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class,array('label'=>'E-post',))
			->add('firstName', TextType::class,array('label'=>'Fornavn',))
			->add('lastName', TextType::class,array('label'=>'Etternavn',))
			->add('phone', TextType::class,array('label'=>'Telefonnummer',))

			->add('save', SubmitType::class, array('label' => 'Endre bruker','attr'=>array('class'=>'btn btn-default')));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User',
		));
	}
}
