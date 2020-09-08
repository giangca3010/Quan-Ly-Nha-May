<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChiPhi extends Model
{
	protected $table = 'chi_phi';
	protected $fillable = [
        'id_cp','name',
    ];
    protected $primaryKey = 'id_cp';
}