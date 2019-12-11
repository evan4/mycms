<?php 

namespace App\Models;

use Mycms\Model;
use Exception;

class Article
{
    private $db;

    public function __construct()
    {
        $this->db = new Model('articles');
    }

    public function getArticle(array $data)
    {
        return $this->db->select($data);
    }

    public function getArticles(array $params = null, array $data = null)
    {
        return $this->db->selectAll($params, $data);
    }

    public function saveArticl(array $data)
    {
        return $this->db->insert($data);
    }
    
}
