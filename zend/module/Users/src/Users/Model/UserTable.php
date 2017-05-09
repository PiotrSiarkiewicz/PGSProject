<?php

namespace  Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveUser(User $user)
    {
        $data = [
            'login' => $user->login,
            'password' => $user->password,
            'email' => $user->email,
            'name' => $user->name,
            'surname' => $user->surname
        ];
        $id = (int)$user->id;
        if($id == 0)
        {
            $this->tableGateway->insert($data);
        }
        else
        {
            if($this->getUser($id))
            {
                $this->tableGateway->update($data,['id' => $id]);
            }
            else
            {
                throw new \Exception("Użytkowanik o tym ID nie istnieje");
            }
        }
    }

    public function getUser($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if(!row)
        {
            throw new \Exception('Nie mogę znaleść rekordu o ID =  '.$id);
        }
        return $row;

    }
}