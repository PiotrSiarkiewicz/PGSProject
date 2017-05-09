<?php

namespace Users\Form;
use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('Register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/formdata');
        $this->setAttribute('class', 'form-horizontal');
        
        $this->add([
            'name' => 'name',
            'attributes' => [
                'type' => 'text'
            ],
            'options' => [
                'label' => 'Imię i nazwisko'
            ]
            ]
        );
        
        $this->add([
            'name' => 'email',
            'attributes' => [
                'type' => 'text'
            ],
            'options' => [
                'label' => 'Email'
            ],
            'filters' => [
                'required' => 'required',
            ],
            'validators' => [
                    [
                        'name' => 'EmailAddress',
                        'options' => [
                            'messages' => [
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Podany adres ma nieprawidłowy format'
                            ]
                        ]
                    ]
            ]
            ]
        );
        
        $this->add([
            'name' => 'password',
            'attributes' => [
                'type' => 'password'
            ],
                'options' => [
                    'label' => 'Hasło'
                ]
            ]
        );
        
        $this->add([
            'name' => 'confirm_password',
            'attributes' => [
                'type' => 'password'
            ],
                'options' => [
                    'label' => 'Hasło ponownie'
                ]
            ]
        );
        
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Prześlij',
            ],
                'options' => [
                    'label' => 'Ok'
                ]
            ]
        ); 
    }
}

?>