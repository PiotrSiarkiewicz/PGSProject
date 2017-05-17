<?php
namespace Users\Model;

use Zend\Authentication\Validator\Authentication;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;

class SurveyTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(array('iduser'=>$this->iduser=19)); //record only for iduser=19
        $session = new Container('base');
        $session->offsetSet('iduser', $this->iduser);
        return $resultSet;
    }

    public function getSurvey($idsurvey)
    {
        $idsurvey  = (int) $idsurvey;
        $rowset = $this->tableGateway->select(array('idsurvey' => $idsurvey));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $idsurvey");
        }
        return $row;
    }

    public function saveSurvey(Survey $survey)
    {
        $status = "complete";
        $session = new Container('base');
        $iduser = $session->offsetGet('iduser'); //gettting iduser from session
        $date = date('Y/m/d h:i:s ');
        $data = array(
            'status' => $status,
            'date' => $survey->date=$date,
            'iduser'=> $survey->iduser=$iduser,
            'description' => $survey->description,
            'title'  => $survey->title,
        );

        $idsurvey = (int) $survey->idsurvey;
        if ($idsurvey == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getSurvey($idsurvey)) {
                $this->tableGateway->update($data, array('idsurvey' => $idsurvey));
            } else {
                throw new \Exception('Survey id does not exist');
            }
        }
    }

    public function deleteAlbum($idsurvey)
    {
        $this->tableGateway->delete(array('idsurvey' => (int) $idsurvey));
    }
}