<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{

    public function userprofile()
    {
        return $this->belongsTo(userprofile::class);
    }
}
