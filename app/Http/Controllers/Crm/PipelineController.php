<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index()
    {
        $columns = ['New', 'InReview', 'Quoted', 'Approved', 'Closed'];

        $pipeline = [];
        foreach ($columns as $col) {
            $pipeline[$col] = ClientRequest::with('client')
                ->where('status', $col)
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return view('crm.pipeline.index', compact('pipeline', 'columns'));
    }

    public function move(Request $request, ClientRequest $clientRequest)
    {
        $request->validate([
            'status' => 'required|in:New,InReview,Quoted,Approved,Closed',
        ]);

        $clientRequest->update(['status' => $request->status]);

        return response()->json(['ok' => true]);
    }
}

