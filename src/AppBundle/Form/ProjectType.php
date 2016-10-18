<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

/* // Hidden imports that may be used if the IvoryGoogleMaps library is installed
use Ivory\GoogleMapBundle\Form\Type\PlacesAutocompleteType;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
*/

class ProjectType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class, array('attr' => array('placeholder' => 'name')))
			->add('field', TextType::class, array('attr' => array('placeholder' => 'field')))
			->add('startdate', DateTimeType::class)
			->add('enddate', DateTimeType::class)
//			->add('technicalSolutions', TextType::class, array('attr' => array('placeholder' => 'technical solutions'))) // To be changed
			->add('description', TextareaType::class, array('attr' => array('placeholder' => 'description')))
			
			// Field to input address. Gets used up to 25000 times a day. That means up to 25000 edits and creations per day.
			->add('location', TextType::class, array('attr' => array('placeholder' => "adresse på formen 'gatenavn gatenummer, tettsted'")))
			/* This form field has better usability, but I could not make the api key work.
			->add('place', PlacesAutocompleteType::class, array(

				// Javascript prefix variable
				'prefix' => 'js_prefix_',

				// Autocomplete types
				'types'  => array(
					AutocompleteType::GEOCODE,
					AutocompleteType::CITIES,
					AutocompleteType::REGIONS,
					AutocompleteType::ESTABLISHMENT,
				),

				// Autocomplete component restrictions
				'component_restrictions' => array(
					AutocompleteComponentRestriction::COUNTRY => 'no',
					Other possible restrictions include 	63.4297222, 10.3933333
					AutocompleteComponentRestriction::ROUTE => 'route';
					AutocompleteComponentRestriction::LOCALITY => 'locality';
					AutocompleteComponentRestriction::ADMINISTRATIVE_AREA => 'administrative_area';
					AutocompleteComponentRestriction::POSTAL_CODE => 'postal_code';
					AutocompleteComponentRestriction::COUNTRY => 'country';
					
				),

				// TRUE if the autocomplete is loaded asynchonously else FALSE
				'async' => false,

				// Autocomplete language
				'language' => 'no', // alternatively, en for English
			))
			*/
			->add('actors', EntityType::class, array(
				// query choices from this entity
				'class' => 'AppBundle:Actor',

				// use the Actor.email property as the visible option string
				'choice_label' => 'email',

				// used to render a select box, check boxes or radios
				'multiple' => true,
				// 'expanded' => true,
			))
			->add('captcha', CaptchaType::class, array(
				'label' => ' ',
				'width' => 200,
				'height' => 50,
				'length' => 5,
				'quality' =>200,
				'keep_value' => true,
				'distortion' => false,
				'background_color' => [255, 255, 255]))
			->add('save', SubmitType::class, array ('label' => 'Lag'));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Project',
		));
	}

}