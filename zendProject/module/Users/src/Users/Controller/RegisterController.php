<?php

namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\RegisterForm;
use Zend\Db\TableGateway\TableGateway;
use Users\Model\User;
use Users\Model\UserTable;
use Zend\Db\ResultSet\ResultSet;


class RegisterController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new RegisterForm();
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function confirmAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    protected function createUser(array $data)
    {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new User);

        $tableGateway = new TableGateway('user', $dbAdapter, null, $resultSetPrototype);

        $user = new User();
        $user->exchangeArray($data);
        $userTable = new UserTable($tableGateway);
        $userTable->saveUser($user);

        return true;
    }


    public function processAction()
    {
        if(!$this->request->isPost())
        {
            return $this->redirect()->toRoute(null, array('controller' => 'register', 'action' => 'index'));
        }

        $post = $this->request->getPost();
        $form = new RegisterForm();
        $inputFilter = new \Users\Validator\RegisterFilter();
        $form->setInputFilter($inputFilter);
        $form->setData($post);

        if(!$form->isValid())
        {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
                ));

            $model->setTemplate('users/register/index');
            return $model;
        }

        if($form->get('password')->getValue() != $form->get('confirm_password')->getValue())
        {
            $model = new ViewModel(array(
                'error' => true,
                'form' => $form,
            ));

            $form->get('password')->setMessages(['Podane hasła nie są identyczne']);

            $model->setTemplate('users/register/index');
            return $model;
        }

        $this->createUser($form->getData());

        return $this->redirect()->toRoute(NULL , array(
            'controller' => 'register',
            'action' => 'confirm'
            ));
    }
}





















?>