<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'deleted_at'
    ];

     public function books()
    {
        return $this->hasMany(Book::class);
    }
}
