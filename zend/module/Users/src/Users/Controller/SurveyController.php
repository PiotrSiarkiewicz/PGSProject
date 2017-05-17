<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\Survey;          // <-- Add this import
use Users\Form\SurveyForm;
use Zend\Session\Container;

class SurveyController extends AbstractActionController
{
    protected $surveyTable;

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
        $session = new Container('base');  //Session creating connection
        echo $session->offsetGet('email');
        return new ViewModel(array(
            'surveys' => $this->getSurveyTable()->fetchAll(),
        ));
    }

    public function createAction()
    {
        $form = new SurveyForm();
        $form->get('submit')->setValue('Create');

        $session = new Container('base');  //Session creating connection
       // $session->offsetSet('iduser', 23); //setting iduser

        $iduser = $session->offsetGet('email');
        echo $iduser;
        $request = $this->getRequest();
        if ($request->isPost()) {

            $survey = new Survey();
            $form->setInputFilter($survey->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {

                $survey->exchangeArray($form->getData());
                $this->getSurveyTable()->saveSurvey($survey);

                return $this->redirect()->toRoute(null,['controller' => 'survey', 'action' => 'index']);
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}