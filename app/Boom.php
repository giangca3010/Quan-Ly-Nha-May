<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boom extends Model
{
	protected $table = 'boom';

	public function getsons($id)
    {
        return $this->where("parent", $id)->get();
    }

    public function getall()
    {
        return $this->orderBy("sort", "asc")->get();
    }

    public static function getNextSortRoot($menu)
    {
        $id = self::where('menu',$menu)->orderBy("id", "desc")->first();
        return  $id->sort + 1;
    }
}
