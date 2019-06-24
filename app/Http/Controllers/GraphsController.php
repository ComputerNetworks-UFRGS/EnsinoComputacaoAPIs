<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graph;
use App\Models\GraphNode;
use App\Models\GraphEdge;
use App\Models\Topic;

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

    public function delete($id)
    {
        $graph = Graph::find($id);
        GraphEdge::where('graph_id', $graph->id)->delete();
        GraphNode::where('graph_id', $graph->id)->delete();
        $graph->delete();
    }

    public function createNode(Request $request, $id)
    {
        $topic = Topic::find($request->topic_id);
        $node = new GraphNode();
        $node->graph_id = $id;
        $node->topic_id = $topic->id;
        $node->title = $topic->name;
        $node->save();
    }

    public function deleteNode($id, $node_id)
    {
        $node = GraphNode::where('graph_id', $id)->find($node_id);

        GraphEdge::where('graph_id', $id)
            ->where('node_from_id', $node->id)
            ->delete();

        GraphEdge::where('graph_id', $id)
            ->where('node_to_id', $node->id)
            ->delete();

        $node->delete();
    }

    public function addEdge(Request $request, $id)
    {
        $edge = new GraphEdge();
        $edge->graph_id = $id;
        $edge->node_from_id = $request->from_id;
        $edge->node_to_id = $request->to_id;
        $edge->save();
        return 'ok';
    }

    public function deleteEdge($id, $from_id, $to_id)
    {
        GraphEdge::where('graph_id', $id)
            ->where('node_from_id', $from_id)
            ->where('node_to_id', $to_id)
            ->delete();
    }

}
