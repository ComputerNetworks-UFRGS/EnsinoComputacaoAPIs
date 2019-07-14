<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraphNode extends Model
{

    public function dependencies()
    {
        return $this->belongsToMany(GraphNode::class, GraphEdge::class, 'node_to_id', 'node_from_id');
    }

    public function dependents()
    {
        return $this->belongsToMany(GraphNode::class, GraphEdge::class, 'node_from_id', 'node_to_id');
    }

}
