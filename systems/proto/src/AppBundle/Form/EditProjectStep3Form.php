<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;

class EditProjectStep3Form extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('measures', CollectionType::class, array(
                'label' => 'Anlagte overvannsløsninger',
                'entry_type' => MeasureType::class,
                'entry_options' => array('includeSubmit' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => true,
                'attr' => array('class' => 'candidate-measures')
                ));
            // 'help' => 'Legg til et eller flere overvannstiltak.'),
    }

    public function finishView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);
        // Text displayed in information box at the top or bottom of form
        $view->vars['create_start_message'] = 'Under kan du legge til et eller flere overvannstiltak. Et overvannstiltak har mange felter å fylle ut. De aller fleste er frivillige, og det går helt fint om du hopper over noen.';
    }

    public function getBlockPrefix() {
        return 'editProjectStep3';
    }

}
