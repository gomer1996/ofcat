<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImportCategoriesQueue extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($queue) {
            Storage::disk('local')->delete('import/' . $queue->url);
        });
    }
}
