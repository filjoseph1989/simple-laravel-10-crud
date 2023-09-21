<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * Define a one-to-one relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
