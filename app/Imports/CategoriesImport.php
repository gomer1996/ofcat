<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CategoriesImport implements ToCollection
{
//    /**
//    * @param array $row
//    *
//    * @return \Illuminate\Database\Eloquent\Model|null
//    */
//    public function model(array $row)
//    {
//        return new Category([
//            'name' => $row[0]
//        ]);
//    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row)
        {
            if ($index === 0 || !$row[0] || !$row[3] || !$row[4]) continue;
            $find = Category::find($row[0]);

            if (!$find) continue;

            $find->discount = $row[3] ? $row[3] : $find->discount;
            $find->tax = $row[4] ? $row[4] : $find->tax;

            $find->save();
        }

    }

}
