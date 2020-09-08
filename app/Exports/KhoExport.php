<?php

namespace App\Exports;

use App\Kho;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;	
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class KhoExport implements FromCollection,WithHeadings,WithTitle,ShouldAutoSize,WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $day;

    public function __construct()
    {
        $this->day  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
    }

    public function collection()
    {
        $kho =  Kho::rightjoin('nguyen_vat_lieu', 'kho.id_nvl', '=', 'nguyen_vat_lieu.id_nvl')->select('kho.id_nvl', 'nguyen_vat_lieu.code', 'nguyen_vat_lieu.name', 'kho.soluong')->get();
        return $kho->map(function($target){
        	return (object)[
        		"id" => $target->id_nvl,
		        "nguyen_vat_lieu" => $target->name,
		        "code" => $target->code,
                'count' => (int)$target->soluong,
		    ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nguyên Vật Liệu',
            'Code',
            'Tồn Kho', 
            'Tồn Kho Mới',   
        ];
    }

    public function title(): string
    {
        return 'Ngày ' . $this->day;
    }
}
