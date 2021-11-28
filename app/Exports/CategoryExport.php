<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cats = Category::select('id', 'name', 'level', 'discount', 'tax')
            ->limit(10)->get();

        $cats->prepend(['ID', 'Наименование', 'Уровень', 'Скидка', 'Процент сверху']);

        return $cats;
    }
}
