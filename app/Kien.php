<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kien extends Model
{
	protected $table = 'kien';

    public static function getNextSortRoot($parent)
    {
        return self::where('parent',$parent)->max('sort') + 1;
    }
}
