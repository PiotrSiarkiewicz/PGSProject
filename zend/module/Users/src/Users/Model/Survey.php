<?php
namespace Users\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Survey implements InputFilterAwareInterface
{
    public $idsurvey;
    public $iduser;
    public $date;
    public $status;
    public $description;
    public $title;
    protected $inputFilter;

    public function exchangeArray($data)
    {

        $this->idsurvey     = (isset($data['idsurvey']))     ? $data['idsurvey']     : null;
        $this->title  = (isset($data['title']))  ? $data['title']  : null;
        $this->iduser   = (isset($data['iduser'])) ? $data['iduser'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->date   = (isset($data['date'])) ? $data['date'] : null;
        $this->status  = (isset($data['status'])) ? $data['status'] : null;

    /*    $this->idsurvey   = (!empty($data['idsurvey'])) ? $data['idsurvey'] : null;
        $this->iduser   = (!empty($data['iduser'])) ? $data['iduser'] : null;
        $this->description = (!empty($data['description'])) ? $data['description'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
        $this->date   = (!empty($data['date'])) ? $data['date'] : null;
        $this->status  = (!empty($data['status'])) ? $data['status'] : null;*/
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();


            $inputFilter->add(array(
                'name'     => 'description',
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

            $inputFilter->add(array(
                'name'     => 'title',
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
