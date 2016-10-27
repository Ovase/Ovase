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
            ->add('title', TextType::class, array('label' => 'Tittel', 'attr' => array('placeholder' => 'Tittel på tiltak')))
            ->add('totalArea', NumberType::class, array('attr' => array('placeholder' => 'Totalt areal')))
            ->add('costs', NumberType::class, array('attr' => array('placeholder' => 'Totale kostnader')))
            ->add('technicalFunctions', TextareaType::class, array('attr' => array('placeholder' => 'Tekniske funksjoner')))
            ->add('elaboration', TextareaType::class, array('attr' => array('placeholder' => 'Utdypning')))
            ->add('additionalValues', TextareaType::class, array('attr' => array('placeholder' => 'Nytteverdier')))
            ->add('geometricDesignElaboration', TextareaType::class, array('attr' => array('placeholder' => 'Utdypning av geometrisk utforming')))
            ->add('constructionDetails', TextareaType::class, array('attr' => array('placeholder' => 'Utdypning av geometrisk utforming')))
            ->add('maintenance', TextareaType::class, array('attr' => array('placeholder' => 'Vedlikehold')))
            ->add('experiencesGained', TextareaType::class, array('attr' => array('placeholder' => 'Erfaringer og tips')))
            ->add('save', SubmitType::class, array('label' => 'Legg til'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Measure'
        ));
    }
}