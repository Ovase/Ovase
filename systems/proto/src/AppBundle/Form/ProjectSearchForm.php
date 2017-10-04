<?php

namespace AppBundle\Form;

use AppBundle\Domain\OvaseDomain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $typeChoices = OvaseDomain::getMeasureTypeChoices();
        $functionChoices = OvaseDomain::getMeasureFunctionChoices();
        $builder
            ->add('search', SearchType::class, array('label' => ' ','attr' => array('placeholder' => 'Tekstsøk'), 'required' => false))
            ->add('measureTypes', ChoiceType::class, array(
                'label' => 'Overvannstiltak',
                'multiple' => true,
                'choices' => $typeChoices,
                'required' => false,
                'attr' => array(
                    'class' => 'function-select js-example-basic-multiple js-states form-control',
                    'style' => 'width: 100%;'),
                ))
            ->add('measureFunctions', ChoiceType::class, array(
                'label' => 'Formål for overvannstiltak',
                'multiple' => true,
                'choices' => $functionChoices,
                'required' => false,
                'attr' => array(
                    'class' => 'function-select js-example-basic-multiple js-states form-control',
                    'style' => 'width: 100%;'),
                ))
            ->add('save', SubmitType::class, array ('label' => 'Utfør søk'))
            ->add('reset', ResetType::class, array ('label' => 'Tilbakestill søk'));
    }
} 