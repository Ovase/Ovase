<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;

class EditProjectStep2Form extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('description', TextareaType::class, array('label' => 'Beskrivelse','attr' => array('help' => 'Vennligst fyll inn en beskrivelse av prosjektet. Hva er utgangs-situasjonen, hvorfor ble det bygget/gjort tiltak? Hvis det har vært problemer eller skader på forhånd, hva var det?')))

            ->add('summary', TextareaType::class, array('label' => 'Oppsummering','attr' => array('help' => 'Vennligst fyll inn en oppsummering av prosjektet. Hvordan håndteres overvannet? Hvor går vannets veier? Hvorfor ble tiltaket/-ene valgt? Erfaringer og tips - Hva er viktig for suksess i lignende prosjekter? ')))
            
            ->add('dimentionalDemands', TextareaType::class, array('label' => 'Dimensjonerende krav','attr' => array('help' => 'Vennligst fyll inn de dimensjonerende kravene til overvannshåndtering til prosjektet. For eksempel fordrøyningsvolum på tomta før påslipp til kommunalt anlegg.')))

            ->add('soilConditions', TextareaType::class, array('label' => 'Beskrivelse av jordsmonnet','attr' => array('help' => 'Vennligst fyll inn en beskrivelse av jordsmonnet der prosjektet er gjennomført.')))

            ->add('totalArea', NumberType::class, array('label' => 'Totalt areal for prosjektområde','attr' => array('help' => 'Vennligst fyll inn totalt areal for prosjektområde i m². Vennligst fyll inn et heltall uten mellomrom, komma eller punktum.')))
            
            ->add('waterArea', NumberType::class, array('label' => 'Totalt areal for nedbørsfelt','attr' => array('help' => 'Vennligst fyll inn totalt areal for nedbørsfelt til overvannstiltakene i m². Vennligst fyll inn et heltall uten mellomrom, komma eller punktum.')))

            ->add('cost', MoneyType::class, array('label'=>'Totale kostnader','currency' => false,'attr' => array('help' => 'Vennligst fyll inn totale kostnader for hele byggeprosjektet i NOK. Vennligst fyll inn et heltall uten mellomrom, komma eller punktum.')))

            ->add('areaType', TextType::class, array('label'=>'Område-type','attr' => array('help' => 'Vennligst fyll inn område-type for prosjektet. For eksempel \'Skolegård\'')))

            ->add('projectType', TextType::class, array('label'=>'Prosjekt-type','attr' => array('help' => 'Vennligst fyll inn prosjekt-type for prosjektet. For eksempel \'Kommunalt\'.')))

            ->add('technicalSolutions', TextType::class, array('label'=>'Tekniske løsninger','attr' => array('help' => 'Vennligst oppgi tiltak som er brukt i prosjektet. Skill tiltakene med komma og mellomrom. Hvert ord skal samsvare med en artikkel i <a href="http://ovase.no/wiki/index.php/Forside">wikien</a> . For eksempel \'Grønne tak for flomdemping, Regnbed\'.')))

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
            ));
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

    public function buildView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);
        $view->vars['endMessage'] = 'Tekst her.';
    }

    public function getBlockPrefix() {
        return 'editProjectStep2';
    }

}
