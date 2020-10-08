<?php 

namespace App\Models;

use Mycms\Model;
use Exception;

class Article
{
    private $db;

    private $table = 'articles';

    public function __construct()
    {
        $this->db = new Model($this->table);
    }

    public function getArticle(array $data)
    {
        return $this->db->select($data);
    }

    public function getArticles(array $params = null, array $data = null)
    {
        return $this->db->selectAll($params, $data);
    }

    public function saveArticle(array $data)
    {
        return $this->db->insert($data);
    }
    
}
