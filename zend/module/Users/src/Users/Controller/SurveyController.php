<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\Survey;          // <-- Add this import
use Users\Form\SurveyForm;
use Zend\Session\Container;
use Zend\Authentication\AuthenticationService;


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

    public function createAction()
    {
        $form = new SurveyForm();
        $form->get('submit')->setValue('Create');


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