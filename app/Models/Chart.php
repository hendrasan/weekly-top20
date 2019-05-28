<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    protected $guarded = [];

    // protected $appends = ['weeks_on_top_10'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function getWeeksOnTop10Attribute()
    // {
    //   return 1;
    // }
}
