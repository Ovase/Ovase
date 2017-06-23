<?php

use Craue\FormFlowBundle\Form\FormFlow;

abstract class OvaseFormFlow extends FormFlow {
    public function invalidateStepData($fromStepNumber) {
        // Do nothing
    }
} 