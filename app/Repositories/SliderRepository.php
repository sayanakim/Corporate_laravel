<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\Slider;


class SliderRepository extends Repository {

    public function __construct(Slider $slider) {

        $this->model = $slider;
    }

}
