<?php
namespace Users\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;


class AnswerTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    public function fetchAll()
    {
        $session = new Container('creation');
        $idquestion = $session->offsetGet('idquestion');
        $resultSet = $this->tableGateway->select(array('idquestion' => $idquestion));
        $row = $resultSet->current();
        $session->offsetSet('idanswer',$row->idanswer);
      //  $idanswer = $session->offsetGet('text');
        echo $idquestion;
        return $resultSet;
    }

    public function getAnswer($idanswer)
    {
        $idanswer  = (int) $idanswer;
        $rowset = $this->tableGateway->select(array('idanswer' => $idanswer));
        $row = $rowset->current();
        if (!$row) {
                throw new \Exception("Could not find row $idanswer");
            }
            return $row;

    }

    public function saveAnswer(Answer $answer)
    {

        $session = new Container('creation');
        $idquestion = $session->offsetGet('idquestion'); //gettting iduser from session
        $text = $_POST['texta'];
        $data = array(
            'text' => $answer->text=$text,
            'idquestion'=> $answer->idquestion=$idquestion,
            'type' => $answer->type="jakis",
        );
        if($session->offsetExists('idanswer'))
        {
            $idanswer=$session->offsetGet('idanswer');

        }else
        $idanswer = (int) $answer->idanswer;
        if ($idanswer == 0) {
            $this->tableGateway->insert($data);
            $resultSet =  $this->tableGateway->select(['text'=> $text]);
            $row = $resultSet->current();
            $session->offsetSet('idanswer',$row->idanswer);
        } else {
            if ($this->getAnswer($idanswer)) {
                $this->tableGateway->update($data, array('idanswer' => $idanswer));

            } else {
                throw new \Exception('Answer id does not exist');
            }
        }
    }

    public function deleteAnswer($idanswer)
    {
        $this->tableGateway->delete(array('idanswer' => (int) $idanswer));
    }
}