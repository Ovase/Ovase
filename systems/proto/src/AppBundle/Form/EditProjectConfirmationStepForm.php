<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EditProjectConfirmationStepForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('permission', CheckboxType::class, array(
                'label' => 'Tillatelse fra prosjekteier',
                'mapped' => false,
                'attr' => array('help' => 'For å legge ut prosjektet på Ovase.no må det være klarert med prosjekteier. Kryss av boksen under om dette er gjort.')));
    }

    public function getBlockPrefix() {
        return 'editProjectConfirmationStep';
    }

}
