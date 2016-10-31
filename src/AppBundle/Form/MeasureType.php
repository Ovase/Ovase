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
            ->add('title', TextType::class, array('label' => 'Tittel', 'attr' => array('placeholder' => 'Tittel på tiltak','help' => 'My help msg')))
            ->add('totalArea', NumberType::class, array('label' => 'Totalt areal','attr' => array('placeholder' => 'Totalt areal','help' => 'My help msg')))
            ->add('costs', NumberType::class, array('label' => 'Kostnad','attr' => array('placeholder' => 'Totale kostnader','help' => 'My help msg')))
            ->add('technicalFunctions', TextareaType::class, array('label' => 'Tekniske funksjoner','attr' => array('placeholder' => 'Tekniske funksjoner','help' => 'My help msg')))
            ->add('elaboration', TextareaType::class, array('label' => 'Utdypning for tekniske funksjoner','attr' => array('placeholder' => 'Utdypning','help' => 'My help msg')))
            ->add('dimentionalDemands', TextareaType::class, array('label' => 'Dimensjonerende krav','attr' => array('placeholder' => 'Oppsummering','help' => 'My help msg'),'label_attr' => array('id' => 'description_label')))
            ->add('additionalValues', TextareaType::class, array('label' => 'Tilleggsverdier','attr' => array('placeholder' => 'Nytteverdier','help' => 'My help msg')))
            ->add('geometricDesignElaboration', TextareaType::class, array('label' => 'Geometrisk utforming','attr' => array('placeholder' => 'Utdypning av geometrisk utforming','help' => 'My help msg')))
            ->add('constructionDetails', TextareaType::class, array('label' => 'Konstruksjonsdetaljer og anleggelse','attr' => array('placeholder' => 'Utdypning av geometrisk utforming','help' => 'My help msg')))
            ->add('maintenance', TextareaType::class, array('label' => 'Drift, vedlikehold og oppfølging','attr' => array('placeholder' => 'Vedlikehold','help' => 'My help msg')))
            ->add('experiencesGained', TextareaType::class, array('label' => 'Erfaringer og tips','attr' => array('placeholder' => 'Erfaringer og tips','help' => 'My help msg')))
            ->add('save', SubmitType::class, array('label' => 'Legg til'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Measure'
        ));
    }
}