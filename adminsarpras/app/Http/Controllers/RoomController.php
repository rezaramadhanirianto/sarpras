<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Room;
use App\Model\Users;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::get();
        $users = Users::latest()->get();
        return view('admin.rooms.index', compact('rooms', 'users'));
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
        $this->validate($request, [
            'room' => 'required|integer|min:100',
        ]);
        $rooms = Room::create([
            'room' => $request->room,
        ]);
        return redirect(route('rooms.index'))->with(['success' => 'data ruangan berhasil diinput.']);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser($idroom, $id_user)
    {
        $rooms = Room::findOrFail($idroom);
        $users = Users::where('roles', '0')->get();
        
        $user = Users::find($id_user);
        return view('admin.rooms.edit', compact('rooms', 'users', 'user'));
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
        $user = Users::where('room_id',$request->id);
        $rooms = Room::findOrFail($id);
        if($request->user_id == "0"){
            $rooms->id = 0;
        }else{

        }
        $user->update([
            "room_id" => $rooms->id
        ]);
        return redirect(route('rooms.index'))->with(['success' => 'data ruangan berhasil diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Users::where('room_id', $id)->first();
        if($user){
            $user->room_id = "0";
            $user->save();
        }
        $rooms = Room::findOrFail($id);
            $rooms->delete();
        return redirect(route('rooms.index'))->with(['success' => 'data ruangan berhasil dihapus.']);
    }
}
