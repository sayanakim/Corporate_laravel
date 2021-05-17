<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Lavary\Menu\Menu;

class AdminController extends Controller
{
    //
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = FALSE;
    protected $title;
    protected $vars;

    public function __construct()
    {
        $this->user = Auth::user();

//        if (!$this->user) {
//            abort(403);
//        }
    }


    public function renderOutput()
    {
        // заголовок
        $this->vars = Arr::add($this->vars, 'title', $this->title);

        // меню
        $menu = $this->getMenu();

        // навигация
        $navigation = view(env('THEME').'.admin.navigation')->with('menu', $menu)->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        // контент
        if ($this->content) {
            $this->vars = Arr::add($this->vars, 'content', $this->content);
        }

        // футер
        $footer = view(env('THEME').'.admin.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        // шаблон
        return view($this->template)->with($this->vars);
    }

    public function getMenu()
    {
        return \Menu::make('adminMenu', function ($menu)
        {
            $menu->add('Статьи');
            $menu->add('Портфолио');
            $menu->add('Меню');
            $menu->add('Пользователи');
            $menu->add('Привелегии');
        });
    }

}
