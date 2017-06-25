<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CompanyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class,array('label'=>'Navn',))
			->add('email', EmailType::class,array('label'=>'E-post',))
            ->add('tlf', TextType::class,array('label'=>'Telefonnummer',))
            ->add('location', TextType::class, array('label'=>'Adresse','attr' => array('placeholder' => "Adresse på formen 'gatenavn gatenummer, tettsted'")))
			->add('type', TextType::class)
			->add('org_nr', TextType::class,array('label'=>'Organisasjonsnummer',))
			->add('persons', EntityType::class, array(
				// query choices from this entity
				'label'=>'Medvirkende',
				'class' => 'AppBundle:Person',

				// use the Actor.email property as the visible option string
				'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'required' => false,
				// 'expanded' => true,
				'attr' => array('class'=>'js-example-basic-multiple js-states form-control','help' => 'Vennligst velg de aktørene som har vært med på prosjektet. Trykk først inn på feltet, velg deretter aktører ved enten å trykke på navnet deres eller skriv inn navn og trykk på enter. For å fjerne en aktør fra feltet trykk på krysset til venstre for navnet eller bruk backspace. PS: Dersom aktøren ikke finnes her må den opprettes på aktør siden.')
			))
			->add('competence', TextareaType::class,array('label'=>'Kompetanse',))
			->add('image', FileType::class, array('label'=>'Last opp bilde','mapped' => false, 'required'=>false))
			->add('captcha', CaptchaType::class, array(
			'attr' => array('placeholder' => 'Skriv tegnene'),
			'label' => 'Bevis at du ikke er en robot',
			'width' => 200,
			'height' => 50,
			'length' => 5,
			'quality' =>200,
			'keep_value' => true,
			'distortion' => false,
			'background_color' => [255, 255, 255],
		))
			->add('save', SubmitType::class, array('label' => 'Lag selskap','attr'=>array('class'=>'btn btn-default')));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Company',
		));
	}
}
