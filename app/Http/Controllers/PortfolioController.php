<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Repositories\MenusRepository;
use App\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PortfolioController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep)
    {
        parent::__construct(new MenusRepository(new Menu));

        $this->p_rep = $p_rep;

        $this->template = env('THEME') . '.portfolios';
    }


    public function index()
    {
        $this->title = 'Портфолио';
        $this->keywords = 'Портфолио';
        $this->meta_desc = 'Портфолио';

        // получаем записи из таблицы БД
        $portfolios = $this->getPortfolios();
//        dd($portfolios);

        $content = view(env('THEME') . '.portfolios_content')->with('portfolios', $portfolios)->render();
        $this->vars = Arr::add($this->vars, 'content', $content);



        return $this->renderOutput();
    }


    public function getPortfolios($take = FALSE, $paginate = TRUE)
    {
        $portfolios = $this->p_rep->get('*', $take, $paginate);
//        dd($portfolios);

        if ($portfolios) {
            $portfolios->load('filter');
        }
        return $portfolios;
    }


    // отдельный материал раздела ПОРТФОЛИО
    public function show($alias)
    {
        $portfolio = $this->p_rep->one($alias);
        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), FALSE);
//        dd($portfolios);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;


        $content = view(env('THEME') . '.portfolio_content')->with(['portfolio' => $portfolio, 'portfolios' => $portfolios])->render();
        $this->vars = Arr::add($this->vars, 'content', $content);


        return $this->renderOutput();
    }

}
