<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\Survey;          // <-- Add this import
use Users\Form\SurveyForm;

use Users\Model\Question;          // <-- Add this import
use Users\Model\Answer;

use Zend\Session\Container;



class SurveyController extends AbstractActionController
{
    protected $surveyTable;
    protected $questionTable;
    protected $answerTable;

    public function getAuthService()
    {
        if(!$this->authservice)
        {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'surveys','title','description'); //sprawdz

            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $this->authservice = $authService;
        }

        return $this->authservice;
    }

    public function getSurveyTable()
    {
        if (!$this->surveyTable) {
            $sm = $this->getServiceLocator();
            $this->surveyTable = $sm->get('Users\Model\SurveyTable');
        }
        return $this->surveyTable;
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

    public function logoutAction()
    {
        $name = 'base' ;
        $container = new Container($name);
        $container->getManager()->getStorage()->clear($name);

        return $this->redirect()->toRoute(NULL , array(
            'controller' => 'login',
            'action' => 'index'
        ));
    }

    public function indexAction()
    {

        $session = new Container('base');
        if (!$session->offsetExists('iduser')) {
            return $this->redirect()->toRoute('users' , array(
                'controller' => 'login',
                'action' => 'index'
            ));
        }


        return new ViewModel(array(
            'surveys' => $this->getSurveyTable()->fetchAll(),
        ));
    }

    public function createAction()
    {
        $form = new SurveyForm();
        $session= new Container('creation');

        $form->get('submit')->setValue('Add question');  //dodane

        $form->get('submitc')->setValue('Confirm');

        $form->get('submitq')->setValue('Add Answer');
        $form->get('submita')->setValue('Add Answer');
        $form->get('submituq')->setValue('Update Question text');
        $form->get('submitua')->setValue('Update Answer text');
        $post = $this->request->getPost();
        $form->setData($post);
        $request = $this->getRequest();


        //Submit and Quit
        if(isset($_POST['submitc'])) {
            $session->getManager()->getStorage()->clear('creation');
            return $this->redirect()->toRoute(null, ['controller' => 'survey', 'action' => 'index']);
        }

        //Adding Questions
        if((isset($_POST['submitq']) || isset($_POST['submituq']))&& $_POST['text']!="") {


            $question = new Question();
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                if(isset($_POST['submitq']))
                    $session->offsetUnset('idquestion');
                $session->offsetSet('answer', 2); //will be created answer field
                $question->exchangeArray($form->getData());
                $this->getQuestionTable()->saveQuestion($question);
            }
        }



        //Adding Answers
        if((isset($_POST['submita'])|| isset($_POST['submitua']))&& $_POST['texta']!="") {

            $answer = new Answer();
            $form->setInputFilter($answer->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $nanswer= $session->offsetGet('answer')+1;

               /* if(isset($_POST['submita']))
                    $session->offsetUnset('idanswer');*/
                $session->offsetSet('answer', $nanswer);
                $answer->exchangeArray($form->getData());
                $this->getAnswerTable()->saveAnswer($answer);
            }
        }

        //Adding Survey
        if(isset($_POST['submit']))
        {

            $session->offsetSet('question',1);
            $survey = new Survey();
            $form->setInputFilter($survey->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $survey->exchangeArray($form->getData());
                $this->getSurveyTable()->saveSurvey($survey);
            }

        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $form  = new SurveyForm();
        $session = new Container('creation');
        $idsurvey = (int) $this->params()->fromRoute('idsurvey', 0);
        $session->offsetSet('idsurvey',$idsurvey);
        if (!$idsurvey) {
            return $this->redirect()->toRoute('survey', array(
                'action' => 'create'
            ));
        }


        $survey = $this->getSurveyTable()->getSurvey($idsurvey);



        $form->bind($survey);
        $form->get('submit')->setAttribute('value', 'Edit');
        $this->getQuestionTable()->fetchAll();

        $idquestion = $session->offsetGet('idquestion');
        if($idquestion!=0)
        {
            $question = $this->getQuestionTable()->getQuestion($idquestion);
            $form->bind($question);
        }
        $form->get('submituq')->setAttribute('value', 'Edit');
        $form->get('submitq')->setAttribute('value', 'Add Question');

        $this->getAnswerTable()->fetchAll();
        $idanswer = $session->offsetGet('idanswer');
        if($idanswer!=0)
        {
            $answer = $this->getAnswerTable()->getAnswer($idanswer);
            $form->bind($answer);
        }

        $form->get('submitua')->setAttribute('value', 'Edit');
        $form->get('submita')->setAttribute('value', 'Add Answer');
        $form->get('submitc')->setValue('Confirm');
       // $form->get('submitc')->setAttribute('value', 'Confirm');
        //nowe

        $request = $this->getRequest();


        if(isset($_POST['submit']))
        {
            $form->setInputFilter($survey->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                echo $survey->title;
                $this->getSurveyTable()->saveSurvey($survey);
            }
        }


        if(isset($_POST['submituq']))
        {
            $question = new Question();
            $form->setInputFilter($question->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getQuestionTable()->saveQuestion($question);
            }
        }

        if(isset($_POST['submitua']))
        {
            $answer = new Answer();
            $form->setInputFilter($answer->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                echo $survey->title;
                $this->getAnswerTable()->saveAnswer($answer);
            }
        }

        if(isset($_POST['submitc'])) {
            echo "przyciks a";
            $session->getManager()->getStorage()->clear('creation');
            return $this->redirect()->toRoute(null, ['controller' => 'survey', 'action' => 'index']);
        }

        return array(
            'idquestion' => $idquestion,
            'idsurvey' => $idsurvey,
            'form' => $form,
        );
    }

    public function deleteAction()
    {

        $idsurvey = (int) $this->params()->fromRoute('idsurvey', 0);
        if (!$idsurvey) {
            return $this->redirect()->toRoute('survey');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $idsurvey = (int) $request->getPost('idsurvey');
                $this->getSurveyTable()->deleteSurvey($idsurvey);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('survey');
        }

        return array(
            'idsurvey'    => $idsurvey,
            'survey' => $this->getSurveyTable()->getSurvey($idsurvey)
        );
    }
}