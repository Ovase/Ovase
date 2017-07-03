<?php

namespace AppBundle\Form;

use AppBundle\Domain\OvaseDomain;
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
            ->add('title', TextType::class, array('label' => 'Tittel'))
            ->add('type', ChoiceType::class, array(
                'label' => 'Type overvannstiltak',
                'placeholder' => 'Velg type overvannstiltak',
                'choices' => $typeChoices))
            ->add('functions', ChoiceType::class, array(
                'label' => 'Tiltakets formål',
                'placeholder' => 'Velg ett eller flere formål',
                'multiple' => true,
                'choices' => $functionChoices,
                'attr' => array('class' => 'function-select js-example-basic-multiple js-states form-control'),
                ))
            // Quantified facts
            ->add('dimentionalWaterAmount', NumberType::class, array(
                'label' => 'Dimensjonerende vannmengde (m³)', 'required' => false))
            ->add('dimentionalFlood', NumberType::class, array(
                'label' => 'Dimensjonerende flom', 'required' => false))
            ->add('area', NumberType::class, array(
                'label' => 'Tiltakets overflateareal (m²)', 'required' => false))
            ->add('catchmentArea', NumberType::class, array(
                'label' => 'Tiltakets nedbørsfelt (m²)', 'required' => false))
            ->add('hydraulicConductivity', NumberType::class, array(
                'label' => 'Målt hydraulisk konduktivitet (cm/time)', 'required' => false))
            ->add('costs', NumberType::class, array(
                'label' => 'Tiltakets kostnader (NOK)', 'required' => false))
            // Text fields
            ->add('soilConditions', TextareaType::class, array(
                'label' => 'Grunnforhold', 'required' => false))
            ->add('designAndConstruction', TextareaType::class, array(
                'label' => 'Tiltakets utforming og konstruksjonsutførelse', 'required' => false))
            ->add('maintenance', TextareaType::class, array(
                'label' => 'Planlagt eller utført vedlikehold og oppfølging', 'required' => false))
            ->add('experiencesGained', TextareaType::class, array(
                'label' => 'Erfaringer og tips', 'required' => false));
            // No save button as one is created by FormFlow
            if ($options['includeSubmit'])
                $builder->add('save', SubmitType::class, array('label' => 'Legg til'));
    }

    public function finishView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);

        // Help texts
        $view['functions']->vars['attr']['help'] = 'Her kan du velge et eller flere formål. Fagwikien har mer info om <a target="_blank" href="http://wiki.ovase.no/index.php/Hydrologi_i_overvannstiltak">vann-tekniske</a>, <a target="_blank" href="http://wiki.ovase.no/index.php/Økologi_i_overvannstiltak">økologiske</a> og <a target="_blank" href="http://wiki.ovase.no/index.php/Opplevelseskvalitet_i_overvannstiltak">sosiale</a> formål.';

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Measure',
            'includeSubmit' => true,
        ));
    }
}