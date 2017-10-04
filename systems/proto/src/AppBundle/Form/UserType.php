<?php

// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
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
			->add('phone', TextType::class,array('label'=>'Telefonnummer', 'required' => false))
			->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array(
					'label' => 'Passord',
					'attr' => array('help' => 'Passordet må være minst 8 tegn langt, og inneholde minst en liten og stor bokstav, samt et tall.'),
					),
				'second_options' => array('label' => 'Gjenta Passord'),
				'attr' => array('help' => 'Test'),
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
		$builder->add('save', SubmitType::class, array('label' => 'Registrer bruker'));
	}

    public function finishView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);

        $view->vars['create_start_message'] = 'Velkommen! Her kan du registrere deg som usynlig bruker. Etter å ha blitt godkjent kan du lage en synlig personprofil, legge til prosjekter og virksomheter, dele erfaringer under andres prosjekter og skrive i fagwikien.';
    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User',
		));
		$resolver->setRequired('environment'); // send array w/constructor in controller
	}
}
