<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
			->add('name', TextType::class, array('label' => 'Navn','attr' => array('help' => 'Vennligst skriv inn navnet prosjektet skal ha på nettsiden.')))


			->add('images', CollectionType::class, array(
                'entry_type' => HiddenType::class,
                'disabled' => true,
                'required' => false,
                'allow_delete' => true,
            ))

            ->add('imageFiles', FileType::class, array('required' => false, 'label' => 'Last opp bilder','mapped' => false, 'multiple' => true,'attr' => array('help' => "Vennligst klikk 'Velg filer', trykk deg frem til mappen med bildene du vil laste opp. Velg deretter ett eller flere bilder du vil ha på prosjekt siden din. For å velge flere bilder holder du inn 'ctrl' knappen og trykker på bildene du vil ha (bildene må ligge i samme mappe). Deretter trykk 'Åpne'.")))

			->add('startdate', TextType::class,array(
			    'label' => 'Start dato',
                'attr' => array('onchange' => 'disableDates()','help' => 'Vennligst trykk på feltet og velg en dato fra kalenderen. Du kan også skrive inn dato selv på formen: dd.mm.åååå')
                ))

			->add('enddate', TextType::class, array('label' => 'Slutt dato','attr' => array('help' => 'Vennligst trykk på feltet og velg en dato fra kalenderen. Du kan også skrive inn dato selv på formen: dd.mm.åååå. Det vil ikke gå ann å sette en slutt-dato som er før start-datoen du har satt.')))

			->add('description', TextareaType::class, array('label' => 'Beskrivelse','attr' => array('help' => 'Vennligst fyll inn en beskrivelse av prosjektet. Hva er utgangs-situasjonen, hvorfor ble det bygget/gjort tiltak? Hvis det har vært problemer eller skader på forhånd, hva var det?')))

            ->add('summary', TextareaType::class, array('attr' => array('placeholder' => 'Oppsummering','help' => 'Vennligst fyll inn en oppsummering av prosjektet. Hvordan håndteres overvannet? Hvor går vannets veier? Hvorfor ble tiltaket/-ene valgt? Erfaringer og tips - Hva er viktig for suksess i lignende prosjekter? ')))
            
            ->add('dimentionalDemands', TextareaType::class, array('label' => 'Dimensjonerende krav','attr' => array('help' => 'Vennligst fyll inn de dimensjonerende kravene til overvannshåndtering til prosjektet. For eksempel fordrøyningsvolum på tomta før påslipp til kommunalt anlegg.')))

            ->add('soilConditions', TextareaType::class, array('label' => 'Beskrivelse av jordsmonnet','attr' => array('help' => 'Vennligst fyll inn en beskrivelse av jordsmonnet der prosjektet er gjennomført.')))

            ->add('totalArea', NumberType::class, array('label' => 'Totalt areal for prosjektområde','attr' => array('help' => 'Vennligst fyll inn totalt areal for prosjektområde i m². Vennligst fyll inn et heltall uten mellomrom, komma eller punktum.')))
            
            ->add('waterArea', NumberType::class, array('label' => 'Totalt areal for nedbørsfelt','attr' => array('help' => 'Vennligst fyll inn totalt areal for nedbørsfelt til overvannstiltakene i m². Vennligst fyll inn et heltall uten mellomrom, komma eller punktum.')))

            ->add('cost', MoneyType::class, array('label'=>'Totale kostnader','currency' => false,'attr' => array('help' => 'Vennligst fyll inn totale kostnader for hele byggeprosjektet i NOK. Vennligst fyll inn et heltall uten mellomrom, komma eller punktum.')))

            ->add('areaType', TextType::class, array('label'=>'Område-type','attr' => array('placeholder' => 'Type område.','help' => 'Vennligst fyll inn område-type for prosjektet. For eksempel \'Skolegård\'')))

            ->add('projectType', TextType::class, array('label'=>'Prosjekt-type','attr' => array('placeholder' => 'Prosjektkategori','help' => 'Vennligst fyll inn prosjekt-type for prosjektet. For eksempel \'Kommunalt\'.')))

            ->add('technicalSolutions', TextType::class, array('label'=>'Tekniske løsninger','attr' => array('help' => 'Vennligst oppgi tiltak som er brukt i prosjektet. Skill tiltakene med komma og mellomrom. Hvert ord skal samsvare med en artikkel i <a href="http://ovase.no/wiki/index.php/Forside">wikien</a> . For eksempel \'Grønne tak for flomdemping, Regnbed\'.')))

			// Field to input address. Gets used up to 25000 times a day. That means up to 25000 edits and creations per day.
			->add('location', TextType::class, array('label' => 'Lokasjon','attr' => array('help' => 'Vennligst fyll inn en adresse på formen \'gatenavn gatenummer, tettsted\'. For eksempel \'Kongens gate 9, 7013 Trondheim\'.')))


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
				'label'=>'Medvirkende',
				'class' => 'AppBundle:Actor',

				// use the Actor.email property as the visible option string
				'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'required' => false,
				// 'expanded' => true,
				'attr' => array('class'=>'js-example-basic-multiple js-states form-control','help' => 'Vennligst velg de aktørene som har vært med på prosjektet. Trykk først inn på feltet, velg deretter aktører ved enten å trykke på navnet deres eller skriv inn navn og trykk på enter. For å fjerne en aktør fra feltet trykk på krysset til venstre for navnet eller bruk backspace. PS: Dersom aktøren ikke finnes her må den opprettes på aktør siden.')
			))
			->add('captcha', CaptchaType::class, array('attr' => array('placeholder' => 'Skriv tegnene','help' => 'test catpcha'),
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