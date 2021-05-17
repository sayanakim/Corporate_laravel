<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Repositories\ArticlesRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use App\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;


class IndexController extends SiteController
{
    public function __construct(SliderRepository $s_rep, PortfoliosRepository $p_rep, ArticlesRepository $a_rep)
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        $this->bar = 'right';
        $this->template = env('THEME').'.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = $this->getPortfolio();
//        dd($portfolios);

        $content = view(env('THEME') . '.content')->with('portfolios', $portfolios)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);


        $sliderItems = $this->getSliders();
//        dd($sliderItems);

        $sliders = view(env('THEME') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = Arr::add($this->vars, 'sliders', $sliders);

        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME') . '.indexBar')->with('articles', $articles)->render();
//        dd($articles);

        return $this->renderOutput();
    }


    protected function getArticles()
    {
        $articles = $this->a_rep->get(['title', 'created_at', 'img', 'alias'],Config::get('settings.home_articles_count') );
        return $articles;
    }

    protected function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', Config::get('settings.home_port_count'));
        return $portfolio;
    }

    public function getSliders()
    {
        $sliders = $this->s_rep->get();
        if($sliders->isEmpty()) {
            return FALSE;
        }

        $sliders->transform(function ($item, $key) {
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;
            return $item;
        });
//        dd($sliders);
        return $sliders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
