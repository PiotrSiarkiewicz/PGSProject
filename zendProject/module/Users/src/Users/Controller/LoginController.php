<?php

namespace Users\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\User;
use Users\Model\UserTable;
use Users\Form\LoginForm;

class LoginController extends AbstractActionController
{
    public function getAuthService()
    {
        if(!$this->authservice)
        {
            $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
            $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'user','email','password', 'MD5(?)');

            $authService = new AuthenticationService();
            $authService->setAdapter($dbTableAuthAdapter);
            $this->authservice = $authService;
        }

        return $this->authservice;
    }
    public function indexAction()
    {
        if(!$this->getAuthService()->getStorage()->read('email'))
        {
            $form = new LoginForm();
            $viewModel = new ViewModel(['form' => $form]);
            return $viewModel;
        }
        else
        {
            $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
            return $this->redirect()->toRoute(null,['controller' => 'login', 'action' => 'confirm']);
        }

    }

    public function processAction()
    {
        if(!$this->request->isPost())
        {
            return $this->redirect()->toRoute(null, array('controller' => 'login', 'action' => 'index'));
        }

        $this->getAuthService()->getAdapter()->setIdentity($this->request->getPost('email'))->setCredential($this->request->getPost('password'));

        $result = $this->getAuthService()->authenticate();

        if($result->isValid())
        {
            $this->getAuthService()->getStorage()->write($this->request->getPost('email'));
            return $this->redirect()->toRoute(Null,['cotroller' => 'login', 'action' => 'confirm']);
        }
        else
        {
            $post = $this->request->getPost();
            $form = new LoginForm();
            $form->setData($post);

            $model = new ViewModel(['form' => $form]);
            $form->get('email')->setMessages(['Nieprawidłowe dane']);

            $model->setTemplate('user/login/index');
            return $model;
        }
        return $this->redirect()->toRoute(null,['controller' => 'login', 'action' => 'index']);
    }

    public function confirmAction()
    {
        if($this->getAuthService()->getStorage()->read('email'))
        {
            $user_email = $this->getAuthService()->getStorage()->read();
            $viewModel = new ViewModel(['user_email' => $user_email]);
            return $viewModel;
        }
        return $this->redirect()->toRoute(null,['controller' => 'login', 'action' => 'index']);
    }
}