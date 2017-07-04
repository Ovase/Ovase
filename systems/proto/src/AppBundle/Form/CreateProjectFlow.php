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

class CreateProjectFlow extends FormFlow implements EventSubscriberInterface {

    protected $allowDynamicStepNavigation = true;
    protected $handleFileUploads = false;
    protected $validationGroupPrefix = "flow_editProject_step";
    private $logger;
    private $imgService;

    public function __construct(LoggerInterface $logger, ImageService $imgService) {
        $this->logger = $logger;
        $this->imgService = $imgService;
    }

    protected function loadStepsConfig() {
        return array(
            1 => array(
                'label' => 'Prosjekt',
                'form_type' => 'AppBundle\Form\EditProjectStep1Form',
            ),
            2 => array(
                'label' => 'Overvannstiltak',
                'form_type' => 'AppBundle\Form\EditProjectStep2Form',
            ),
            3 => array(
                'label'=> 'Se over',
                'form_type' => 'AppBundle\Form\EditProjectConfirmationStepForm',
            ),
        );
    }

    public function getFormOptions($step, array $options = array()) {
        $options = parent::getFormOptions($step, $options);
        $options['validation_groups'] = array(
            'Default',
            $this->validationGroupPrefix . $step,
        );
        return $options;
    }

    public function setEventDispatcher(EventDispatcherInterface $dispatcher) {
        parent::setEventDispatcher($dispatcher);
        $dispatcher->addSubscriber($this);
    }

    public static function getSubscribedEvents() {
        return array(
            FormFlowEvents::PRE_BIND => 'onPreBind',
        );
    }

    private function retrieveUploadedFiles($request, $stepName, $fileUploadName) {
        $uploadedImages = array();
        $formFiles = $request->files->get($stepName);
        if (is_null($formFiles)) return $uploadedImages;
        $imageFiles = $formFiles[$fileUploadName];
        if (is_null($imageFiles)) return $uploadedImages;
        foreach ($imageFiles as $file) {
            if (is_null($file)) continue;
            $uploadedImages[] = $file;
        }
        return $uploadedImages;
    }

    private function clearUploadedFiles($request, $stepName) {
        $request->files->remove($stepName);
    }

    // Move uploaded images into collection type
    public function onPreBind(PreBindEvent $event) {
        // TODO: Simplify further
        $request = $event->getFlow()->getRequest();
        $imageFiles = $this->retrieveUploadedFiles($request, 'editProjectStep1', 'imageFiles');
        $newImages = array();
        foreach ($imageFiles as $file) {
            $newImg = new ProjectImage();
            $url = $this->imgService->upload($file);
            $newImg->setUrl($url);
            $newImages[] = $newImg;
        }
        $this->clearUploadedFiles($request, 'editProjectStep1');
        // Move files to post params
        $step1Params = $request->request->get('editProjectStep1');
        if (is_null($step1Params)) return;
        $imageCollection = null;
        if (array_key_exists('images', $step1Params))
            $imageCollection = $step1Params['images'];
        else
            $imageCollection = array();
        foreach ($newImages as $img) {
            $imageCollection[] = array('url' => $img->getUrl());
        }
        // Save params back to request
        $step1Params['images'] = $imageCollection;
        $request->request->set('editProjectStep1', $step1Params);
    }
}
