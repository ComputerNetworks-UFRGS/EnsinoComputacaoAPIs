<?php

namespace App\Http\Controllers;

use App\Models\Graph;
use App\Models\GraphEdge;
use App\Models\Topic;

class GraphController extends Controller
{

    public function list()
    {
        return Graph::get();
    }

    public function detail()
    {
        $edges = GraphEdge::select('topic_from_id AS from', 'topic_to_id AS to')->get();

        $topics_ids = $edges->pluck('from')
            ->merge($edges->pluck('to'))
            ->unique()
            ->values();

        $nodes = Topic::select('id', 'name')->whereIn('id', $topics_ids)->get();

        return [
            'nodes' => $nodes,
            'edges' => $edges,
        ];

    }

}
