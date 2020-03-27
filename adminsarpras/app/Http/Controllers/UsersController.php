<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Users;
use App\Model\Room;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function updateUsers(Request $request){
        $users = Users::where('id', $request->id)->first();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->room_id = $request->ruangan;    
        $users->save();
        return back()->with('success', 'Data berhasil diperbaharui');
     }
     public function approved($id){
         $user = Users::find($id);
         if($user->status == "1"){
            $user->status = "0";
            $user->save();
            return ['0'];
         }else{
            $user->status = "1";
            $user->save();
            return ['1'];
         }
        
     }
    public function index()
    {
        $users = Users::where('roles', '0')->get();
        $rooms = Room::all();
        return view('admin.users.index', compact('users', 'rooms'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = Users::where('id', $id)->first();
        $users->room = $users->rooms->room;
        $rooms = Room::all();
        return [$users, $rooms];
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
        // $users = Users::where('id', $id)->first();
        // $users->name = $request->name;
        // $users->email = $request->email;
        // $users->room_id = $request->ruangan;    
        // $users->save();
        // return back()->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = Users::findOrFail($id);
        $users->delete();
        return redirect()->back()->with(['success' => 'data akun berhasil dihapus.']);
    }
}
