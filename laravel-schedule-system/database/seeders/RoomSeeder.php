<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['room_number' => '101', 'building' => 'Building A', 'capacity' => 50, 'room_type' => 'classroom', 'has_projector' => true, 'has_ac' => true],
            ['room_number' => '102', 'building' => 'Building A', 'capacity' => 50, 'room_type' => 'classroom', 'has_projector' => true, 'has_ac' => true],
            ['room_number' => '103', 'building' => 'Building A', 'capacity' => 45, 'room_type' => 'classroom', 'has_projector' => false, 'has_ac' => true],
            ['room_number' => '201', 'building' => 'Building B', 'capacity' => 60, 'room_type' => 'lecture hall', 'has_projector' => true, 'has_ac' => true],
            ['room_number' => '202', 'building' => 'Building B', 'capacity' => 60, 'room_type' => 'lecture hall', 'has_projector' => true, 'has_ac' => true],
            ['room_number' => 'Lab-101', 'building' => 'Building C', 'capacity' => 30, 'room_type' => 'lab', 'has_projector' => true, 'has_ac' => true],
            ['room_number' => 'Lab-102', 'building' => 'Building C', 'capacity' => 30, 'room_type' => 'lab', 'has_projector' => true, 'has_ac' => true],
        ];

        foreach ($rooms as $room) {
            Room::create(array_merge($room, ['is_active' => true]));
        }
    }
}
