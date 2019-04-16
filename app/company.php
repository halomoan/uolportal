<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
