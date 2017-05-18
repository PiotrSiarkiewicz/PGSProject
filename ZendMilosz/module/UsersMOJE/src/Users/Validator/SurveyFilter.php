<?php

namespace Users\Validator;
use Zend\InputFilter\InputFilter;

class SurveyFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
                'name' => 'title',
                'required' => true,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ]
                ]
        ]);



        $this->add([
            'name' => 'description',
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
                        'min' => 1,
                        'max' => 140,
                    ],
                ],
            ],
        ]);
    }
}


?>