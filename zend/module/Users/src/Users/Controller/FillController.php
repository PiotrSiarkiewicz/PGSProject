<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\FillTable;
use Users\Model\Survey;          // <-- Add this import
use Users\Form\SurveyForm;
use Users\Model\Question;          // <-- Add this import
use Users\Model\Answer;
use Zend\Session\Container;



class FillController extends  AbstractActionController
{
    protected $questionTable;

    public function indexAction()
    {
        $idsurvey = (int) $this->params()->fromRoute('idsurvey', 0);
        // grab the paginator from the AlbumTable
        $session = new Container('fill');
        if($idsurvey)  $session->offsetSet('idsurvey', $idsurvey);
        // grab the paginator from the AlbumTable
        $paginator = $this->getQuestionTable()->fetchAll2(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(1);

        $answers = $this->getAnswerTable()->fetchAll2();

        return new ViewModel(array(
            'paginator' => $paginator,
            'answers' => $answers,
        ));
    }
    public function getQuestionTable()
    {
        if (!$this->questionTable) {
            $sm = $this->getServiceLocator();
            $this->questionTable = $sm->get('Users\Model\QuestionTable');
        }
        return $this->questionTable;
    }
    public function getAnswerTable()
    {
        if (!$this->answerTable) {
            $sm = $this->getServiceLocator();
            $this->answerTable = $sm->get('Users\Model\AnswerTable');
        }
        return $this->answerTable;
    }
    public function saveAction()
    {
        var_dump('test123');
        var_dump($this->getRequest()->getPost("data"));
        //$data = json_decode($this->getRequest()->getPost("data"));
        //var_dump($data);
        die();
    }

}
