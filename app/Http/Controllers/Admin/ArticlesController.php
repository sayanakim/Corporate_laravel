<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ArticlesController extends AdminController
{
    public function __construct(ArticlesRepository $a_rep)
    {
        parent::__construct();

        // условие проверки прав и привилегий пользователей
        if (!Gate::denies('VIEW_ADMIN_ARTICLES')) // denies - проверяет, запрещено ли данное действие.
        {
            abort(403);
        }

        $this->a_rep = $a_rep;

        $this->template = env('THEME').'.admin.articles';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $this->title = 'Менеджер статей';
        $articles = $this->getArticles();
//        dd($articles);
        $this->content= view(env('THEME') . '.admin.articles_content')->with('articles', $articles)->render();

        return $this->renderOutput();

    }


    public function getArticles()
    {
        //

        return $this->a_rep->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Gate::denies('save', new Article)) {
            abort(403);
        }

        $this->title = 'Добавить новый материал';



        // КАТЕГОРИЯ
        $categories = Category::select(['title', 'alias', 'parent_id', 'id'])->get();
//        dd($categories);

        $lists = [];

        foreach ($categories as $category) {
            // если родительская категория
            if ($category->parent_id == 0) {
                $lists[$category->title] = [];
            }
            else {
                $lists[$categories->where('id', $category->parent_id)->first()->title][$category->id] = [$category->title];
            }
        }

        dd($lists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
