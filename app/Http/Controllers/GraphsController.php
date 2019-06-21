<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graph;
use App\Models\GraphNode;

class GraphsController extends Controller
{

    public function list()
    {
        return Graph::get();
    }

    public function detail($id)
    {
        $graph = Graph::with([
            'nodes',
            'nodes.dependencies',
            // 'nodes.dependents',
        ])->find($id);

        return $graph;
    }

    public function create(Request $request)
    {
        $graph = new Graph();
        $graph->title = $request->title;
        $graph->description = $request->description;
        $graph->save();
        return 'ok';
    }

    public function createNode(Request $request, $id)
    {
        $node = new GraphNode();
        $node->graph_id = $id;
        $node->topic_id = $request->topic_id;
        $node->title = 'TODO: .... usar topic name';
        $node->save();

        // TODO: processar lista de dependencias

    }

    public function deleteNode($id, $node_id)
    {
        // TODO: ...
    }

}
