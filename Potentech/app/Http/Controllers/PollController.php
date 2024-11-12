<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'question' => 'required|string',
            'options' => 'required|array',
            'time_limit' => 'required|integer',
        ]);
    
        $poll = Poll::create(array_merge($validated, ['created_by' => auth()->id()]));
    
        return response()->json($poll, 201);
    }

    public function show(Poll $poll) {
        if ($poll->isExpired()) {
            return response()->json(['message' => 'Poll has expired'], 403);
        }
        return response()->json($poll->load('responses'));
    }

    public function submitResponse(Request $request, Poll $poll) {
        $validated = $request->validate([
            'response' => 'required|string',
        ]);

        $poll->responses()->create([
            'user_id' => auth()->id(),
            'response' => $validated['response'],
        ]);

        return response()->json(['message' => 'Response submitted'], 200);
    }

    public function results(Poll $poll) {
        return response()->json($poll->responses()->select('response', DB::raw('count(*) as count'))->groupBy('response')->get());
    }

    public function index(Request $request) {
        $user = $request->user();

        $polls = Poll::with('responses')
            ->where('room_id', $request->room_id)
            ->when($user->role_id != 1, function ($query) use ($user) {
                return $query->where('created_by', $user->id);
            })
            ->get()
            ->map(function ($poll) {
                $poll->is_expired = $poll->isExpired();
                return $poll;
            });

        return response()->json($polls);
    }
}
