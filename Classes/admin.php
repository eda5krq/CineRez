<?php
require_once __DIR__ . '/User.php';

class Admin extends User
{
    private $permissions;

    public function __construct($name, $email, $role = 'admin', $permissions = [])
    {
        parent::__construct($name, $email, $role);
        $this->permissions = $permissions;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    public function canManageMovies()
    {
        return in_array('manage_movies', $this->permissions, true);
    }

    public function getDashboardMessage()
    {
        return 'Admin panel active. You can monitor reservations and manage cinema operations.';
    }
}
