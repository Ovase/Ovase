<?php

// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$env = $options['environment'];
		$builder
			->add('email', EmailType::class,array('label'=>'E-post',))
			->add('firstName', TextType::class,array('label'=>'Fornavn',))
			->add('lastName', TextType::class,array('label'=>'Etternavn',))
			->add('phone', TextType::class,array('label'=>'Telefonnummer',))
			->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array('label' => 'Passord'),
				'second_options' => array('label' => 'Gjenta Passord'),
				)
			);
		if ($env != 'test') {
			$builder->add('captcha', CaptchaType::class, array(
				'attr' => array('placeholder' => 'Skriv tegnene'),
				'label' => 'Bevis at du ikke er en robot',
				'width' => 200,
				'height' => 50,
				'length' => 5,
				'quality' =>200,
				'keep_value' => true,
				'distortion' => false,
				'background_color' => [255, 255, 255],
			));
		}
		$builder->add('save', SubmitType::class, array('label' => 'Registrer bruker','attr'=>array('class'=>'btn btn-default')));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User',
		));
		$resolver->setRequired('environment'); // send array w/constructor in controller
	}
}
