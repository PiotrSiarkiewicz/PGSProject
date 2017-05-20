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

        $idsurvey = (int) $this->params()->fromRoute('idsurvey', 0);
        if (!$idsurvey) {
            return $this->redirect()->toRoute('survey', array(
                'action' => 'create'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
         try {
             $survey = $this->getSurveyTable()->getSurvey($idsurvey);

         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('survey', array(
                 'action' => 'index'
             ));
         }

        $form  = new SurveyForm();
        $form->bind($survey);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($survey->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getSurveyTable()->saveSurvey($survey);

                // Redirect to list of albums
                return $this->redirect()->toRoute('survey');
            }
        }

        return array(
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