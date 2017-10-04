<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProjectStep2Form extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('images', CollectionType::class, array(
                'label' => 'Opplastede bilder',
                'required' => false,
                'entry_type' => ProjectImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => array('class' => 'candidate-images'),
                ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);
        $view->vars['create_start_message'] = 'Her kan du skrive bildetekster og slette bilder. Gå til forrige side for å laste opp flere bilder.';
    }

    public function getBlockPrefix() {
        return 'editProjectStep2';
    }

}
