<?php


namespace AppBundle\Tests\Form;

use AppBundle\Form\PersonSearchForm;

use Symfony\Component\Form\Test\TypeTestCase;

class PersonSearchFormTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
        );

        $form = $this->factory->create(PersonSearchForm::class);

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