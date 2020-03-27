<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Borrow;
use App\Model\RoomItem;
use App\Model\Item;
use App\Model\Room;
use App\Model\Users;
use App\Model\Returned;

class ReturnBorrowItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        $borrowed = Borrow::all();
        $rooms = Room::all();
        return view("admin.borrow.index", compact('items', 'borrowed', 'rooms'));
    }

   public function pengembalian(){
       $returned = Returned::all();
       return view("admin.returned.index", compact('returned'));
   }
    public function create()
    {
        //
    }
    public function returnedDetail($id){
        
        $borrowed = Returned::find($id)->borrowed;
        

        $roomItem = RoomItem::find($borrowed->room_item_id);
        $roomItem->person = $borrowed->person;
        $roomItem->item = $roomItem->item;
        $roomItem->room = $roomItem->room->room;
        $roomItem->satuan = $roomItem->item->satuan->satuan;
        $roomItem->tipe = $roomItem->item->tipe->tipe;
        $a = explode(' ', $borrowed->created_at);
        $roomItem->tgl_pinjam = $a[0];
        $roomItem->total = $borrowed->quantity;
        $date = explode(' ', $borrowed->created_at);
        $roomItem->date= $date[0];
        return $roomItem;

    }
    public function editBorrowed($id){
        $borrowed = Borrow::find($id);
        $borrowed->room = $borrowed->roomitem->room->id;
        $borrowed->item = $borrowed->roomitem->item->id;
        $room_id = $borrowed->roomitem->room_id;
        $roomItem = RoomItem::where('room_id', $room_id)->get();
        $items = [];
        foreach ($roomItem as $r ) {
            array_push($items, $r->item);
        }
        return [$borrowed, $items];
    }
    public function store(Request $request)
    {

        if($request->id != ""){
            $roomItem = RoomItem::where("item_id",$request->item)->first();
            $borrowed = Borrow::find($request->id);
                if($request->total > $roomItem->total + $borrowed->quantity ){
                    return back()->with('error', "Barang Kurang");
                }

            $roomItem->total = $roomItem->total + $borrowed->quantity;

            $borrowed->room_item_id = $roomItem->id;
            $borrowed->quantity = $request->total;
            $borrowed->person = $request->user;

            $roomItem->total = $roomItem->total - $borrowed->quantity;

            $roomItem->save();
            $borrowed->save();

        }else{
            $roomItem = RoomItem::where('item_id', $request->item)->first();
            if($request->total > $roomItem->total ){
                return back()->with('error', "Barang Kurang");
            }
            Borrow::create([
                'room_item_id' => $roomItem->id,
                'quantity' => $request->total,
                'person' => $request->user
            ]);
            $roomItem->total = $roomItem->total - $request->total;
            $roomItem->save();
        }
        return back()->with('success', "Berhasil meminjam");
    }
    public function pengembalianBarang(Request $request){
        $borrowed = Borrow::find($request->id);
        $roomItem = RoomItem::find($borrowed->room_item_id);
        if($request->status == "1"){
            $roomItem->total = $roomItem->total + $borrowed->quantity;
        }else if($request->status == "0"){
            $roomItem->total_rusak = $borrowed->quantity;
        }
        $roomItem->save();

        $returned = Returned::create([
            'borrowed_item_id' => $borrowed->id,
            'status_item' => $request->status
        ]);
        return back()->with('success', "Berhasil mengembalikan");
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $roomItem = RoomItem::where('room_id', $id)->get();
        $items = [];
        foreach ($roomItem as $r ) {
            $item = Item::find($r->item_id);
            array_push($items, $item);
        }
        return $items;
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
