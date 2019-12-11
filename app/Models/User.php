<?php 

namespace App\Models;

use Mycms\Model;
use Exception;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Model('users');
    }

    public function getUser(array $data)
    {
        return $this->db->select($data);
    }

    public function getUsers(array $params, array $data)
    {
        return $this->db->selectAll($params, $data);
    }

    public function saveUser(array $data)
    {
        return $this->db->insert($data);
    }
    
}
