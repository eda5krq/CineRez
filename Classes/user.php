<?php
class User
{
    protected $name;
    protected $email;
    protected $role;

    public function __construct($name, $email, $role = 'user')
    {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getDashboardMessage()
    {
        return 'Welcome back, ' . $this->name . '. You can browse movies and reserve tickets.';
    }
}
