<?php

namespace App\Exceptions;

use App\Http\Controllers\SiteController;
use App\Models\Menu;
use Exception;



class UserNotFoundException extends Exception
{
    public function render($request, Exception $e) {
        if ($this->isHttpException($e)) {
            $statusCode = $e->getStatusCode();

            switch ($statusCode) {
                case '404':

                    $obj = new SiteController(new Menu());
                    $navigation = view(env('THEME').'.navigation')->with('menu', $obj)->getMenu()->render();

                    \Log::alert('Страница не найдена - '. $request->url());

                    return response()->view(env('THEME').'.404', ['bar' => 'no', 'title' => 'Страница не найдена', 'navigation' => $navigation]);
            }
        }
        return parent::render($request, $e);
    }
}
