<?php
namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;

class SurveyTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
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
        $data = array(
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