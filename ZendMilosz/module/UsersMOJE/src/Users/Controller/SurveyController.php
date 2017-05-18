<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\Survey;          // <-- Add this import
use Users\Model\SurveyTable;
use Users\Form\SurveyForm;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use \DateTime;

class SurveyController extends AbstractActionController
{
    protected $surveyTable;
    protected function createSurvey(array $data)
    {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Survey);

        $tableGateway = new TableGateway('surveys', $dbAdapter, null, $resultSetPrototype);

        $survey = new Survey();

        $survey->exchangeArray($data);
        $surveyTable = new SurveyTable($tableGateway);
        $surveyTable->saveSurvey($survey);

        return true;
    }

    public function getAuthService()
    {
        if(!$this->authservice)
        {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'surveys','title','description');

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
    public function indexAction()
    {
        return new ViewModel(array(
            'surveys' => $this->getSurveyTable()->fetchAll(),
        ));
    }


    public function createAction()
    {


        $post = $this->request->getPost();
        $form = new SurveyForm();
        $inputFilter = new \Users\Validator\SurveyFilter();
        $form->setInputFilter($inputFilter);
        $form->setData($post);

        if(!$form->isValid())
        {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
            ));

            $model->setTemplate('users/survey/create');
            return $model;
        }

        $today = getdate();
        $date = date('m/d/Y h:i:s a', time());
        echo $date;

        $this->createSurvey($form->getData());  //utworzenie wpisu w tabeli
        /*$form = new SurveyForm();
        $form->get('submit')->setValue('Create');

        $request = $this->getRequest();
        if ($request->isPost()) {
            echo "tutaj";
            $survey = new Survey();
            $form->setData($request->getPost());
            $form->setInputFilter($survey->getInputFilter());


            if ($form->isValid()) {
                echo "przeszlo";
                $survey->exchangeArray($form->getData());
                $this->getSurveyTable()->saveSurvey($survey);

                return $this->redirect()->toRoute(null,['controller' => 'survey', 'action' => 'index']);
            }
        }*/
       // return array('form' => $form);
        return $this->redirect()->toRoute(NULL , array(
            'controller' => 'survey',
            'action' => 'index'
        ));  //przeniesienie do confirm
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}