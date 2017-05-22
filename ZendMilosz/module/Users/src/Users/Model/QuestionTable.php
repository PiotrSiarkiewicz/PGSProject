<?php
namespace Users\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;

use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

use Zend\Db\TableGateway\Feature;

class QuestionTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    public function fetchAll()
    {
        $session = new Container('creation');
        $idsurvey = $session->offsetGet('idsurvey');
        $resultSet = $this->tableGateway->select(array('idsurvey' => $idsurvey));
        $row = $resultSet->current();
        $session->offsetSet('idquestion',$row->idquestion);
       // $session->offsetSet('text',$resultSet->text);
        return $resultSet;
    }

    public function getQuestion($idquestion)
    {
        $session = new Container('creation');
        $idsurvey = $session->offsetGet('idsurvey');
        $idquestion  = (int) $idquestion;
        $rowset = $this->tableGateway->select(array('idsurvey' => $idsurvey));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $idquestion");
        }

        $session ->offsetSet('idquestion',$row->idquestion);
        return $row;
    }

    public function saveQuestion(Question $question)
    {

        $session = new Container('creation');
        $idsurvey = $session->offsetGet('idsurvey'); //gettting iduser from session
        $text = $_POST['text'];
        $data = array(
            'text' => $question->text=$_POST['text'],
            'idsurvey'=> $question->idsurvey=$idsurvey,
        );
        if($session->offsetExists('idquestion'))
        {
            $idquestion=$session->offsetGet('idquestion');
        }else
        $idquestion = (int) $question->idquestion;
        if ($idquestion == 0) {

            $this->tableGateway->insert($data);
            $resultSet =  $this->tableGateway->select(['text'=> $text]);
            $row = $resultSet->current();
            $session->offsetSet('idquestion',$row->idquestion);
        } else {
            if ($this->getQuestion($idquestion)) {
                $this->tableGateway->update($data, array('idquestion' => $idquestion));

            } else {
                throw new \Exception('Question id does not exist');
            }
        }
    }

    public function deleteQuestion($idquestion)
    {
        $this->tableGateway->delete(array('idquestion' => (int) $idquestion));
    }
}