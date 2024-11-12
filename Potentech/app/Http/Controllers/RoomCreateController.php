<?php

namespace App\Http\Controllers;

use App\Models\RoomCreate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roomCheckedIfAvailable = RoomCreate::where('roomId', $request->roomId)->where('isStilAvailable', 0)->first();
        if (!$roomCheckedIfAvailable) {
            $roomCreate = new RoomCreate();
            $roomCreate->roomId = $request->roomId;
            $roomCreate->createdBy = Auth::user()->name;
            $roomCreate->save();

            $room = new Room();
            $room->room_id = $request->roomId;
            $room->room_name = $request->roomName;
            $room->save();
        } else {
            return response()->json(['error' => 'The room ID is already taken.'], 409);
        }

        return response()->json($roomCreate, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomCreate  $roomCreate
     * @return \Illuminate\Http\Response
     */
    public function show(RoomCreate $roomCreate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomCreate  $roomCreate
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomCreate $roomCreate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomCreate  $roomCreate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomCreate $roomCreate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomCreate  $roomCreate
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomCreate $roomCreate)
    {
        //
    }

    public function checkIfExist(Request $request)
    {
        $roomCheckedIfAvailable = RoomCreate::where('roomId', $request->roomId)->where('isStilAvailable', 0)->first();

        return response()->json($roomCheckedIfAvailable);
    }

    public function checkRoom(Room $room, int $room_id)
    {
        $room = Room::where('room_id', $room_id)->first();

        return response()->json($room);
    }
}
