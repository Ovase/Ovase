<?php


namespace AppBundle\Tests\Form;

use AppBundle\Form\ProjectSearchForm;

use Symfony\Component\Form\Test\TypeTestCase;

class ProjectSearchFormTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
        );

        $form = $this->factory->create(ProjectSearchForm::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}