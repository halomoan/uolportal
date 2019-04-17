<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    public function userprofile()
    {
        return $this->belongsTo(UserProfile::class);
    }

}
