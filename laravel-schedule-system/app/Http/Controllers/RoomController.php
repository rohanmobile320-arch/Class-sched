<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['show']);
    }

    public function index()
    {
        $rooms = Room::paginate(15);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms|max:20',
            'building' => 'required|max:255',
            'capacity' => 'required|integer|min:10|max:500',
            'room_type' => 'required|in:classroom,lab,lecture hall',
            'has_projector' => 'boolean',
            'has_ac' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id . '|max:20',
            'building' => 'required|max:255',
            'capacity' => 'required|integer|min:10|max:500',
            'room_type' => 'required|in:classroom,lab,lecture hall',
            'has_projector' => 'boolean',
            'has_ac' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
