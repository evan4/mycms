<?php 

namespace App\Models;

use Mycms\Db;
use Exception;

class User
{
    public function __construct()
    {
     
       new Db();
    }
}
