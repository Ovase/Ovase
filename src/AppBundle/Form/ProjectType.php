<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Ivory\GoogleMapBundle\Form\Type\PlacesAutocompleteType;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;

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
			->add('description', TextType::class, array('attr' => array('placeholder' => 'description')))
			->add('save', SubmitType::class, array ('label' => 'Lag'))
			
			// Field to input
			->add('place', PlacesAutocompleteType::class, array(

				// Javascript prefix variable
				'prefix' => 'js_prefix_',

				// Autocomplete bound (array|Ivory\GoogleMap\Base\Bound)
				//'bound'  => $bound,

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
					/* Other possible restrictions include 	63.4297222, 10.3933333
					AutocompleteComponentRestriction::ROUTE => 'route';
					AutocompleteComponentRestriction::LOCALITY => 'locality';
					AutocompleteComponentRestriction::ADMINISTRATIVE_AREA => 'administrative_area';
					AutocompleteComponentRestriction::POSTAL_CODE => 'postal_code';
					AutocompleteComponentRestriction::COUNTRY => 'country';
					*/
				),

				// TRUE if the autocomplete is loaded asynchonously else FALSE
				'async' => false,

				// Autocomplete language
				'language' => 'en', // alternatively, no for Norwegian
			))

			->add('captcha', CaptchaType::class, array(
				'label' => ' ',
				'width' => 200,
				'height' => 50,
				'length' => 5,
				'quality' =>200,
				'keep_value' => true,
				'distortion' => false,
				'background_color' => [255, 255, 255]));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Project',
		));
	}

}