<?php

namespace App\Controllers;

use Mycms\Controller;
use Mycms\View;
use App\Models\Article;

class HomeController extends Controller
{

    public function index()
    {
        $meta = [
            'title' => 'Home'
        ];

        $articles = new Article();
        $articles = $articles->getArticles();
       
        $home = new View('home@index');

        $home->render(compact('meta', 'articles'));
    }
}
