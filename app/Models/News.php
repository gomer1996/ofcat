<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getIntroContentAttribute(): string
    {
        return $this->attributes["content"] ? Str::limit($this->attributes["content"], 100) : "";
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d.m.y');
    }
}
