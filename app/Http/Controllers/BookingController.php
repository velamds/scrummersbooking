<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Http\Resources\Booking as BookingResource;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type, $checkin, $checkout)
    {
        $booked = collect(Booking::whereBetween('checkin',[$checkin,$checkout])
                        ->OrWhereBetween('checkout',[$checkin,$checkout])
                        ->select('room_id')
                        ->get());
        $booked = $booked->unique('room_id');
        $booked->values()->all();
        $rooms = array();
        foreach ($booked as $room) {
            array_push($rooms,$room->room_id);
        }

        return BookingResource::collection(
            Room::join('room_types', 'rooms.type_id' ,'=' ,'room_types.id')
            ->where('type_id','=',$type)
            ->whereNotIn('rooms.id',$rooms)
            ->select('rooms.id as room_id','type_id','beds','name')
            ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
