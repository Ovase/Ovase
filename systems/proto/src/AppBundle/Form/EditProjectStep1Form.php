<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProjectStep1Form extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $years = range(date('Y'), Date('Y') - 30);
        $yearChoices = array_combine($years, $years);
        $builder
            ->add('name', TextType::class, array('label' => 'Prosjektnavn'))
            ->add('enddate', ChoiceType::class, array(
                'label' => 'Ferdigstilt år',
                'placeholder' => 'Velg år',
                'choices' => $yearChoices))
            ->add('projectOwner', TextType::class, array('label' => 'Byggherre'))
            ->add('location', TextType::class, array('label' => 'Adresse'))
            ->add('coordLat', HiddenType::class, array('data' => 0.0))
            ->add('coordLong', HiddenType::class, array('data' => 0.0))
            ->add('leadText', TextType::class, array('label' => 'Kort sammendrag')) ->add('description', TextareaType::class, array(
                'label' => 'Beskrivelse',
                'required' => false))
            ->add('summary', TextareaType::class, array(
                'label' => 'Oppsummering',
                'required' => false))
            ->add('actors', EntityType::class, array(
                'label'=>'Medvirkende',
                // Choices from this entity
                'class' => 'AppBundle:Actor',
                // Display actor name in select field
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
                ))
            /* imageFiles are not directly mapped, but instead uploaded to cloudinary, and the URLs are persisted in the controller */
            ->add('imageFiles', FileType::class, array('required' => false, 'label' => 'Last opp bilder', 'multiple' => true))
            /* No label and styled to be invisible on first page */
            ->add('images', CollectionType::class, array(
                'label' => ' ',
                'required' => false,
                'entry_type' => ProjectImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => array('style' => 'display: none;'),
                ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);
        // Text displayed in information box at the bottom of the form
        // $view->vars['create_end_message'] = 'Du kan nå publisere prosjektet, men vi hadde satt stor pris på om du vil legge til litt mer informasjon.';

        // Help texts
        $view['name']->vars['attr']['help'] = 'Navnet prosjektet skal ha på nettsiden.';
        $view['enddate']->vars['attr']['help'] = 'Årstallet når prosjektet ble fullført.';
        $view['location']->vars['attr']['help'] = 'En adresse på formen \'gatenavn gatenummer, tettsted\'. For eksempel \'Kongens gate 9, Trondheim\'.';
        $view['imageFiles']->vars['attr']['help'] = 'Trykk på knappen under og finn de bildene du vil laste opp. Du kan velge flere bilder ved å holde inne kontroll-tasten.';
        $view['leadText']->vars['attr']['help'] = 'En eller to setninger om prosjektet som vil vises i prosjektdatabasen.';
        $view['description']->vars['attr']['help'] = 'Beskrivelse av prosjektet.';
        $view['summary']->vars['attr']['help'] = 'Oppsummering av prosjektet, gjerne med fokus på anlagte overvannstiltak.';
        $view['actors']->vars['attr']['help'] = 'Aktørene som har vært med på prosjektet. Trykk på feltet for å velge aktører som er registrert i våre systemer.';

    }

    public function getBlockPrefix() {
        return 'editProjectStep1';
    }

}
