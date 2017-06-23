<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditProjectStep1Form extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, array('label' => 'Prosjektnavn'))
            ->add('startdate', TextType::class,array('label' => 'Startdato', 'attr' => array('onchange' => 'disableDates()')))
            ->add('enddate', TextType::class, array('label' => 'Sluttdato'))
            ->add('location', TextType::class, array('label' => 'Adresse'))
            ->add('coordLat', HiddenType::class, array('data' => 0.0))
            ->add('coordLong', HiddenType::class, array('data' => 0.0))
            /* imageFiles are not directly mapped, but instead uploaded to cloudinary, and the URLs are persisted in the controller */
            ->add('imageFiles', FileType::class, array('required' => false, 'label' => 'Last opp bilder', 'multiple' => true))
            ->add('images', CollectionType::class, array(
                'entry_type' => ProjectImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                ));

    }

    public function finishView(FormView $view, FormInterface $form, array $options) {
        // Text displayed in information box at the bottom of the form
        $view->vars['end_message'] = 'Du kan nå publisere prosjektet, men vi hadde satt stor pris på om du vil legge til litt mer informasjon.';
        // Help texts
        $view['name']->vars['help'] = 'Vennligst skriv inn navnet prosjektet skal ha på nettsiden.';
        $view['startdate']->vars['help'] = 'Vennligst trykk på feltet og velg en dato fra kalenderen. Du kan også skrive inn dato selv på formen: dd.mm.åååå.';
        $view['enddate']->vars['help'] = 'Vennligst trykk på feltet og velg en dato fra kalenderen. Du kan også skrive inn dato selv på formen: dd.mm.åååå. Det vil ikke gå ann å sette en slutt-dato som er før start-datoen du har satt.';
        $view['location']->vars['help'] = 'Vennligst fyll inn en adresse på formen \'gatenavn gatenummer, tettsted\'. For eksempel \'Kongens gate 9, 7013 Trondheim\'.';
        $view['imageFiles']->vars['help'] = "Vennligst klikk 'Velg filer', trykk deg frem til mappen med bildene du vil laste opp. Velg deretter ett eller flere bilder du vil ha på prosjekt siden din. For å velge flere bilder holder du inn 'ctrl' knappen og trykker på bildene du vil ha (bildene må ligge i samme mappe). Deretter trykk 'Åpne'.";

    }


    public function getBlockPrefix() {
        return 'editProjectStep1';
    }

}
