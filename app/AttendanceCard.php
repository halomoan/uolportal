<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 1/5/2019
 * Time: 10:39 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class AttendanceCard extends Model
{
    protected $dates = ['startdate','enddate'];
    protected $fillable = [
        'title','description','status',
    ];
}