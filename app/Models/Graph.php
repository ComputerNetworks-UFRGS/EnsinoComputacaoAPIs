<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{

    public function nodes()
    {
        return $this->hasMany(GraphNode::class);
    }

    public function edges()
    {
        return $this->hasMany(GraphEdge::class);
    }

}
