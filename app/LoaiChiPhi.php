<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiChiPhi extends Model
{
	protected $table = 'loai_chi_phi';
	protected $fillable = [
        'name_lcp','ma_sp','sl_nk','note'
    ];
}