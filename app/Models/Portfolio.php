<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Filter;

class Portfolio extends Model
{
    public function filter()
    {
        return $this->belongsTo('App\Models\Filter', 'filter_alias', 'alias');
    }
}
