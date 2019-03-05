<?php 

namespace App\Models;

use Mycms\Db;
use Exception;

class User
{
    private
        $db;

    public function __construct()
    {
        $this->db = new Db('users');
        
    }

    public function getUser($data)
    {
        return $this->db->select($data);
    }
}
