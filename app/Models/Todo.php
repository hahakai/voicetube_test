<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'content','title','attachment','done_at','deleted_at'
    ];
}
