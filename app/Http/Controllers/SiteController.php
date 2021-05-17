<?php

namespace App\Http\Controllers;

use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lavary\Menu\Menu;

class SiteController extends Controller
{
    //логика по работе с портфолио
    protected $p_rep;
    //логика по работе со слайдером
    protected $s_rep;
    //логика по работе со статьями
    protected $a_rep;
    //логика по работе с меню
    protected $m_rep;


    protected $keywords;
    protected $meta_desc;
    protected $title;

    //логика по работе с представлениями
    protected $template;

    protected $vars = [];

    // левые и правые сйдбары, если они есть, по умолчанию нет
    protected $contentRightBar = FALSE;
    protected $contentLeftBar = FALSE;

    // сайдбар
    protected $bar = 'no';

    //
    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }



    protected function renderOutput()
    {
        // меню
        $menu = $this->getMenu();
//        dd($menu);

        // навигация
        $navigation = view(env('THEME') . '.navigation')->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        //  если есть правый сайдбар
        if ($this->contentRightBar) {
            $rightBar = view(env('THEME') . '.rightBar')->with('content_rightbar', $this->contentRightBar)->render();
            $this->vars = Arr::add($this->vars, 'rightBar', $rightBar);
        }

        // если есть левый сайбар
        if ($this->contentLeftBar) {
            $leftBar = view(env('THEME') . '.leftBar')->with('content_lefttbar', $this->contentLeftBar)->render();
            $this->vars = Arr::add($this->vars, 'leftBar', $leftBar);
        }

        $this->vars = Arr::add($this->vars, 'bar', $this->bar);
        $this->vars = Arr::add($this->vars, 'keywords', $this->keywords);
        $this->vars = Arr::add($this->vars, 'meta_desc', $this->meta_desc);
        $this->vars = Arr::add($this->vars, 'title', $this->title);


        // футер
        $footer = view(env('THEME') . '.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);


        return view($this->template)->with($this->vars);
    }

    public function getMenu()
    {
        $menu = $this->m_rep->get();

        $mBuilder = (new Menu)->make('MyNav', function ($m) use ($menu) {
            foreach ($menu as $item) {
                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            };
        });

//        dd($mBuilder);

        return $mBuilder;
    }
}
