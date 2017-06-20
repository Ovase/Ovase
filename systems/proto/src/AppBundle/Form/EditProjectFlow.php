<?php

namespace AppBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;

class EditProjectFlow extends FormFlow {

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'Grunnleggende info',
                'form_type' => 'AppBundle\Form\EditProjectStep1Form',
            ),
            array(
                'label' => 'Detaljer',
                'form_type' => 'AppBundle\Form\EditProjectStep2Form',
            ),
            array(
                'label' => 'Se over',
            ),
        );
    }
}
