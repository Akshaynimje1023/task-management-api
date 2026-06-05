<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}