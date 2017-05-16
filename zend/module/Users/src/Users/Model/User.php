<?php

namespace Users\Model;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $surname;
    public $nick;

    public function exchangeArray($data)
    {
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->login = (isset($data['nick'])) ? $data['nick'] : null;
        $this->surname = (isset($data['surname'])) ? $data['surname'] : null;
        if(isset($data['password']))
        {
            $this->password = md5($data['password']);
        }
    }
}
