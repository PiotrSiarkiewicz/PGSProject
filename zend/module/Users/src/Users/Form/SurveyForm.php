<?php

namespace Users\Form;

use Zend\Form\Form;
//tutaj nadajemy nazwy formularza
class SurveyForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('survey');

        $this->add([
            'name' => 'idsurvey',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'iduser',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'Description',
            ],
        ]);
        $this->add([
            'name' => 'status',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'date',
            'type' => 'date',
            'options' => [
                'label' => 'Date',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);


    }
}