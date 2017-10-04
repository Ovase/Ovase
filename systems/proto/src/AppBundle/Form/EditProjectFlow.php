<?php

namespace AppBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Craue\FormFlowBundle\Event\PreBindEvent;
use Craue\FormFlowBundle\Form\FormFlowEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\ImageService;
use AppBundle\Entity\ProjectImage;
use AppBundle\Form\CreateProjectFlow;

class EditProjectFlow extends CreateProjectFlow {

    public function getFormOptions($step, array $options = array()) {
        $options = parent::getFormOptions($step, $options);
        $options['attr']['data-edit'] = 'true';
        return $options;
    }
}
