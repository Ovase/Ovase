<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProjectForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'name')))
            ->add('field', TextType::class, array('attr' => array('placeholder' => 'field')))
            ->add('startdate', TextType::class, array('attr' => array('placeholder' => 'startdate')))
            ->add('enddate', TextType::class, array('attr' => array('placeholder' => 'enddate')))
            ->add('location', TextType::class, array('attr' => array('placeholder' => 'location')))
            ->add('technicalSolutions', TextType::class, array('attr' => array('placeholder' => 'technical solutions')))
            ->add('description', TextType::class, array('attr' => array('placeholder' => 'description')))
            ->add('save', SubmitType::class, array ('label' => 'Lag'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project',
        ));
    }

}