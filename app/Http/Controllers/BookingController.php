<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Http\Resources\Booking as BookingResource;
use App\Http\Resources\Room as RoomResource;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function list(){
        return BookingResource::collection(
            Booking::with('room.roomType')->get()
        );
    }

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
        

        return RoomResource::collection(
            Room::join('room_types', 'rooms.type_id' ,'=' ,'room_types.id')
            ->where('type_id','=',$type)
            ->whereNotIn('rooms.id',$rooms)
            ->select('rooms.id as room_id','type_id','beds','name')
            ->get());
            //->additional(['checkin'=>$checkin,'checkout'=>$checkout])
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Booking;
        $booking->room_id = $request->room_id;
        $booking->checkin = $request->checkin;
        $booking->checkout = $request->checkout;

        $booking->save();
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $booking = Booking::with('room.roomType')->findOrFail($request->id);

        if($booking->room->type_id != $request->type_id){
            Booking::destroy($request->id);
            $newBooking = $this->getRoom($request->checkin,$request->checkout,$request->type_id);
            $booking = new Booking;
            $booking->room_id = $newBooking->room_id;
            $booking->checkin = $request->checkin;
            $booking->checkout = $request->checkout;
        }else{
            $booking->room_id = $request->room_id;
            $booking->checkin = $request->checkin;
            $booking->checkout = $request->checkout;
        }
        $booking->save();
        
    }

    public function getRoom($checkin,$checkout,$type){
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
        
        return Room::join('room_types', 'rooms.type_id' ,'=' ,'room_types.id')
            ->where('type_id','=',$type)
            ->whereNotIn('rooms.id',$rooms)
            ->select('rooms.id as room_id')
            ->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $booking = Booking::destroy($request->id);
        return $request;
    }
}
