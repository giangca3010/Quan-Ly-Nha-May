<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lenh extends Model
{
	protected $table = 'sorting_items';

	public static function getNextSortRoot()
    {
        return self::max('position_order') + 1;
    }
}
