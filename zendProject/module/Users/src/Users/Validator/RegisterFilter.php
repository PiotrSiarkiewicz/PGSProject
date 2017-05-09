<?php

namespace Users\Validator;
use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'domain' => true
                    ]
                ]
            ]
            ]
        );
        
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                [
                    'name' => 'StripTags',
                ],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 140,
                    ],
                ],
                [
                    'name' => 'Users\Validator\EduwebValidator'
                ]
            ],
        ]);
    }
}

?>