<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tipe;
use App\Model\Users;
use App\Model\Room;
use App\Model\Item;

class TipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipe = Tipe::all();
        return view('admin.tipe.index', compact('tipe'));
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
        $this->validate($request,[
            'tipe' => 'required|string|max:100',
        ]);

        $tipe = Tipe::create([
            'tipe' => $request->tipe
        ]);
        return redirect(route('tipe.index'))->with(['success' => 'data jenis barang berhasil ditambah.']);
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
        $tipe = Tipe::findOrFail($id);
        return view('admin.tipe.edit', compact('tipe'));
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
        $this->validate($request, [
            'tipe' => 'required|string|max:100',
        ]);

        $tipe = Tipe::findOrFail($id);
        $tipe->update([
            'tipe' => $request->tipe,
        ]);
        return redirect(route('tipe.index'))->with(['success' => 'data berhasil diperbaharui.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipe = Tipe::findOrFail($id);
        $tipe->delete();
        return redirect()->back()->with(['success' => 'data berhasil dihapus.']);
    }
}
