<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;

class EditProjectStep2Form extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('measures', CollectionType::class, array(
                'label' => 'Anlagte overvannsløsninger',
                'entry_type' => MeasureType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => array(
                    'class' => 'candidate-measures',
                    'help' => 'Legg til et eller flere overvannstiltak.'),
                ));
    }

    public function getBlockPrefix() {
        return 'editProjectStep2';
    }

}
