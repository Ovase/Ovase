<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;

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
			->add('name', TextType::class, array('label' => 'Navn','attr' => array('placeholder' => 'Navn på prosjekt'),'label_attr' => array('id' => 'name_label')))

			->add('field', TextType::class, array('label' => 'Felt','attr' => array('placeholder' => 'Felt'),'label_attr' => array('id' => 'field_label')))

			->add('images', FileType::class, array('mapped' => false, 'multiple' => true,'label_attr' => array('id' => 'images_label')))

			->add('startdate', TextType::class,array('label' => 'Start dato','attr' => array('onchange' => 'disableDates()'),'label_attr' => array('id' => 'startdate_label')))

			->add('enddate', TextType::class, array('label' => 'Slutt dato','label_attr' => array('id' => 'enddate_label')))

			->add('description', TextareaType::class, array('label' => 'Beskrivelse','attr' => array('placeholder' => 'Beskrivelse av prosjektet'),'label_attr' => array('id' => 'description_label')))

            ->add('soilConditions', TextareaType::class, array('attr' => array('placeholder' => 'Beskrivelse av jordsmonnet'),'label_attr' => array('id' => 'soilConditions_label')))

            ->add('totalArea', NumberType::class, array('attr' => array('placeholder' => 'Areal'),'label_attr' => array('id' => 'totalArea_label')))

            ->add('cost', MoneyType::class, array('currency' => false,'label_attr' => array('id' => 'cost_label')))

            ->add('areaType', TextType::class, array('attr' => array('placeholder' => 'Type område.'),'label_attr' => array('id' => 'areaType_label')))

            ->add('projectType', TextType::class, array('attr' => array('placeholder' => 'Prosjektkategori'),'label_attr' => array('id' => 'projectType_label')))

            ->add('technicalSolutions', TextType::class, array('attr' => array('placeholder' => 'Oppgi tiltak. Skill med komma og mellomrom. Hvert ord skal samsvare med en artikkel i wikien.', 'style' => 'width: 800px'),'label_attr' => array('id' => 'technicalSolutions_label')))

			// Field to input address. Gets used up to 25000 times a day. That means up to 25000 edits and creations per day.
			->add('location', TextType::class, array('label' => 'Lokasjon','attr' => array('placeholder' => "Adresse på formen 'gatenavn gatenummer, tettsted'", 'style' => 'width: 600px'),'label_attr' => array('id' => 'location_label')))


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
				'choice_label' => 'name',

				// used to render a select box, check boxes or radios
				'multiple' => true,
                'required' => false,
				// 'expanded' => true,
				'label_attr' => array('id' => 'actors_label'),
				'attr' => array('class'=>'js-example-basic-multiple js-states form-control')
			))
            ->add('measures', CollectionType::class, array(
                'entry_type' => MeasureType::class,
                'allow_add' => true,
                'label_attr' => array('id' => 'measures_label'),
            ))
			->add('captcha', CaptchaType::class, array('attr' => array('placeholder' => 'Skriv tegnene'),
				'label_attr' => array('id' => 'captcha_label'),
				'label' => 'Bevis at du ikke er en robot',
				'width' => 200,
				'height' => 50,
				'length' => 5,
				'quality' =>200,
				'keep_value' => true,
				'distortion' => false,
				'background_color' => [255, 255, 255]))
			->add('save', SubmitType::class, array ('label' => 'Lag','attr'=>array('class'=>'btn btn-default')));//,'label_attr' => array('id' => 'save_label')));
        $builder->get('technicalSolutions')->addModelTransformer(new CallbackTransformer(
            function ($tagsAsArray) {
                // transform the array to a string
                return implode(', ', $tagsAsArray);
            },
            function ($tagsAsString) {
                // transform the string back to an array
                return explode(', ', $tagsAsString);
            }
        ));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Project',
		));
	}

}