<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graph;
use App\Models\GraphNode;
use App\Models\GraphEdge;
use App\Models\LearningObject;
use App\Http\Resources\GraphGoJsResource;
use App\Http\Resources\GraphStepsResource;
use App\Http\Resources\GraphYearsResource;
use App\Http\Resources\GraphJsPlumbResource;

class GraphController extends Controller
{

    public function list()
    {
        return Graph::get();
    }

    public function detail(Request $request, $id)
    {
        // TODO: reduzir dados retornados
        $graph = Graph::with([
            'nodes',
            'nodes.dependencies',
            'nodes.dependents',
            'nodes.learnigObject',
            'nodes.learnigObject.skills',
            'nodes.learnigObject.ageGroup'
        ])->find($id);

        if ($request->view) {
            if ($request->view == 'gojs') {
                return new GraphGoJsResource($graph);
            } else if ($request->view == 'steps') {
                return new GraphStepsResource($graph);
            } else if ($request->view == 'years') {
                return new GraphYearsResource($graph);
            } else if ($request->view == 'jsplumb') {
                return new GraphJsPlumbResource($graph);
            }
        }

        return $graph;
    }

    public function create(Request $request)
    {
        $this->authorize('has-permission', 'curri.create');

        $graph = new Graph();
        $graph->title = $request->title;
        $graph->description = $request->description;
        $graph->save();
        return 'ok';
    }

    public function delete($id)
    {
        $this->authorize('has-permission', 'curri.delete');

        $graph = Graph::find($id);
        GraphEdge::where('graph_id', $graph->id)->delete();
        GraphNode::where('graph_id', $graph->id)->delete();
        $graph->delete();
    }

    public function createNode(Request $request, $id)
    {
        $this->authorize('has-permission', 'curri.edit');

        $object = LearningObject::find($request->object_id);
        $node = new GraphNode();
        $node->graph_id = $id;
        $node->learning_object_id = $object->id;
        $node->title = $object->name;
        $node->save();
    }

    public function deleteNode($id, $node_id)
    {
        $this->authorize('has-permission', 'curri.edit');

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
        $this->authorize('has-permission', 'curri.edit');

        $edge = new GraphEdge();
        $edge->graph_id = $id;
        $edge->node_from_id = $request->from_id;
        $edge->node_to_id = $request->to_id;
        $edge->save();
        return 'ok';
    }

    public function deleteEdge($id, $from_id, $to_id)
    {
        $this->authorize('has-permission', 'curri.edit');

        GraphEdge::where('graph_id', $id)
            ->where('node_from_id', $from_id)
            ->where('node_to_id', $to_id)
            ->delete();
    }
}
