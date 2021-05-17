<?php

namespace App\Repositories;

use T;
use Illuminate\Support\Facades\Config;

abstract class Repository {

    protected $model = FALSE;

    // запрос всех объектов из БД
    public function get($select = '*', $take = FALSE, $pagination = FALSE, $where = FALSE) {

        $builder = $this->model->select($select);
//        dd($builder);

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        if ($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }




    // картинки, если в формате json, то декодируются в объект
    protected function check($result)
    {
        if ($result->isEmpty())
        {
            return FALSE;
        }

        $result->transform(function ($item, $key) {
            if (is_string($item->img) && (is_object(json_decode($item->img))) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }
            return $item;
        });
        return $result;
    }


    public function one($alias, $attr = [])
    {
        $result = $this->model->where('alias', $alias)->first();
        return $result;
    }

}
