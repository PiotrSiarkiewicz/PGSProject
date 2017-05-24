<?php
namespace Users\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Answer implements InputFilterAwareInterface
{
    public $idanswer;
    public $idquestion;
    public $texta;
    public $type;
    protected $inputFilter;

    public function exchangeArray($data)
    {

        $this->idanswer   = (isset($data['idanswer']))     ? $data['idanswer']     : null;
        $this->idquestion     = (isset($data['idquestion']))     ? $data['idquestion']     : null;
        $this->texta  = (isset($data['text'])) ? $data['text'] : null;
        $this->type  = (isset($data['type'])) ? $data['type'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();


            $inputFilter->add(array(
                'name'     => 'text',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
