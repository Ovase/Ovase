<?php
/**
 * Created by PhpStorm.
 * User: futurnur
 * Date: 25/10/2016
 * Time: 13:32
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Tittel'))
            ->add('area', NumberType::class, array('label' => 'Areal'))
            ->add('costs', NumberType::class, array('label' => 'Kostnad'))
            ->add('technicalFunctions', TextareaType::class, array('label' => 'Tekniske funksjoner'))
            ->add('elaboration', TextareaType::class, array('label' => 'Utdypning for tekniske funksjoner'))
            ->add('dimentionalDemands', TextareaType::class, array('label' => 'Dimensjonerende krav'))
            ->add('additionalValues', TextareaType::class, array('label' => 'Tilleggsverdier'))
            ->add('geometricDesignElaboration', TextareaType::class, array('label' => 'Geometrisk utforming'))
            ->add('constructionDetails', TextareaType::class, array('label' => 'Konstruksjonsdetaljer'))
            ->add('maintenance', TextareaType::class, array('label' => 'Drift, vedlikehold og oppfølging'))
            ->add('experiencesGained', TextareaType::class, array('label' => 'Erfaringer og tips'));
            // No save button as one is created by FormFlow
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Measure'
        ));
    }
}