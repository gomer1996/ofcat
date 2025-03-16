<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CategoriesImport implements ToCollection
{
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
