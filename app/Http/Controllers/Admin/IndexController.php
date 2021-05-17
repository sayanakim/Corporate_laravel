<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;

class IndexController extends AdminController
{
    // Главная страница панели администратора

    public function __construct()
    {
        parent::__construct();

        // условие проверки прав и привилегий пользователей
        if (!Gate::denies('VIEW_ADMIN')) // denies - проверяет, запрещено ли данное действие.
        {
            abort(403);
        }

        $this->template = env('THEME').'.admin.index';

    }


    public function index()
    {
        $this->title = 'Панель администратора';

        return $this->renderOutput();
    }
}
