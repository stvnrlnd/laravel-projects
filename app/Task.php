<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    public function path()
    {
        return $this->project->path().'/tasks/'.$this->id;
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
