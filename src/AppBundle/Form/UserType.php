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
			->add('email', EmailType::class)
			->add('lastName', TextType::class)
			->add('firstName', TextType::class)
			->add('phone', TextType::class)
			->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array('label' => 'Passord'),
				'second_options' => array('label' => 'Gjenta Passord'),
				)
			)
			->add('save', SubmitType::class, array('label' => 'Registrer bruker'));
		if ($env != 'test') {
			$builder->add('captcha', CaptchaType::class, array(
				'label' => ' ',
				'width' => 200,
				'height' => 50,
				'length' => 5,
				'quality' =>200,
				'keep_value' => true,
				'distortion' => false,
				'background_color' => [255, 255, 255],
			));
		}
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User',
		));
		$resolver->setRequired('environment'); // send array w/constructor in controller
	}
}
