<?php

namespace AppBundle\Form;

use AppBundle\Domain\OvaseDomain;
use AppBundle\Form\PurifiedCKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeChoices = OvaseDomain::getMeasureTypeChoices();
        $functionChoices = OvaseDomain::getMeasureFunctionChoices();
        $builder
            ->add('title', TextType::class, array('label' => 'Navn på tiltak'))
            ->add('type', ChoiceType::class, array(
                'label' => 'Type overvannstiltak',
                'placeholder' => 'Velg type overvannstiltak',
                'choices' => $typeChoices))
            ->add('description', PurifiedCKEditorType::class, array(
                'label' => 'Tiltaksbeskrivelse',
                'required' => false))
            ->add('functions', ChoiceType::class, array(
                'label' => 'Tiltakets formål',
                'placeholder' => 'Velg ett eller flere formål',
                'multiple' => true,
                'choices' => $functionChoices,
                'attr' => array('class' => 'function-select js-example-basic-multiple js-states form-control'),
                ))
            // Quantified facts
            ->add('area', NumberType::class, array(
                'label' => 'Tiltakets overflateareal (m²)', 'required' => false))
            ->add('catchmentArea', NumberType::class, array(
                'label' => 'Areal av tiltakets delnedbørsfelt (m²)', 'required' => false))
            ->add('hydraulicConductivity', NumberType::class, array(
                'label' => 'Målt hydraulisk konduktivitet (cm/time)', 'required' => false))
            ->add('costs', NumberType::class, array(
                'label' => 'Kostnadsrammer for tiltaket (NOK)', 'required' => false))
            ->add('instrumentation', ChoiceType::class, array(
                'label' => 'Instrumentering',
                'multiple' => false,
                'placeholder' => 'Angi svar',
                'choices' => OvaseDomain::getMeasureInstrumentationChoices(),
                'required' => false
                ));
            // No save button as one is created by FormFlow
            if ($options['includeSubmit'])
                $builder->add('save', SubmitType::class, array('label' => 'Legg til'));
    }

    public function finishView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);

        // Help texts
        $view['title']->vars['attr']['help'] = 'Et beskrivende navn, hovedsaklig brukt for å skille mellom flere overvannstiltak i samme prosjekt.';
        $view['functions']->vars['attr']['help'] = 'Her kan du velge et eller flere formål. Fagwikien har mer info om <a target="_blank" href="http://wiki.ovase.no/index.php/Hydrologi_i_overvannstiltak">vann-tekniske</a>, <a target="_blank" href="http://wiki.ovase.no/index.php/Økologi_i_overvannstiltak">økologiske</a> og <a target="_blank" href="http://wiki.ovase.no/index.php/Opplevelseskvalitet_i_overvannstiltak">sosiale</a> formål.';
        $view['description']->vars['attr']['help'] = 'Beskrivelse av tiltaket. Du står fritt til å legge til eller fjerne overskrifter og annen tekst.';
        $view['instrumentation']->vars['attr']['help'] = 'Er det benyttet instrumentering for å samle måledata fra tiltaket?';

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Measure',
            'includeSubmit' => true,
        ));
    }
}