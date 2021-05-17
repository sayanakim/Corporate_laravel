<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use League\Flysystem\Config;


class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep)
    {
        parent::__construct(new MenusRepository(new Menu));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;

        $this->bar = 'right';

        $this->template = env('THEME') . '.articles';
    }


    public function index($cat_alias = FALSE)
    {
        $this->title = 'Блог';
        $this->keywords = 'String';
        $this->meta_desc = 'String';

        // коллекция моделей из табл.Articles
        $articles = $this->getArticles($cat_alias);
//        dd($articles);
        $content = view(env('THEME') . '.articles_content')->with('articles', $articles)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(\config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(\config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME') . '.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios]);
//        dd($portfolios);

        return $this->renderOutput();
    }



    public function getComments($take)
    {
        $comments = $this->c_rep->get(['text', 'name','email', 'site', 'article_id', 'user_id'], $take);

        if ($comments) {
            $comments->load('article', 'user');
        }

        return $comments;

    }



    public function getPortfolios($take)
    {
        $portfolios = $this->p_rep->get(['title', 'text', 'alias', 'customer', 'img', 'filter_alias'], $take);
        return $portfolios;
    }



    public function getArticles($alias = FALSE)
    {
        $where = FALSE;

        if ($alias) {
            // WHERE `alias` = $alias
            $id = Category::select('id')->where('alias', $alias)->first()->id;
//            dd($id);
            // WHERE `category` = $id
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias', 'created_at', 'img', 'desc',
            'user_id', 'category_id'], FALSE, TRUE, $where);
//        dd($articles);

        if ($articles) {
            $articles->load('user', 'category', 'comments');
        }


        return $articles;
    }


    // отдельный материал раздела БЛОГ
    public function show($alias = FALSE)
    {
        $article = $this->a_rep->one($alias, ['comments' => TRUE]);
//        dd($article);

        if ($article) {
            $article->img = json_decode($article->img);
        }

//        dd($article->comments->groupBy('parent_id'));

        $this->title = $article->title;
        $this->keywords = $article->keywords;
        $this->meta_desc = $article->meta_desc;

        $content = view(env('THEME') . '.article_content')->with('article', $article)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(\config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(\config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME') . '.articlesBar')->with(['comments' => $comments, 'portfolios' => $portfolios]);

        return $this->renderOutput();
    }
};
