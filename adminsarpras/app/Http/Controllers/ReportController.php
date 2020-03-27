<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Report;
use App\Model\RoomItem;
use App\Model\Users;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomitem = RoomItem::all();
        $user = Users::all();
        $report = Report::all();
        
        return view('admin.report.index', compact('report','user','roomitem'));
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
        $report = Report::findOrFail($id);
        $report->update([
            'claim' => 3,
            'reason' => $request->reason,
        ]);
        return redirect(route('report.index'))->with(['success' => 'data kerusakan barang telah di tolak.']);
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

    public function approve(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $roomitem = RoomItem::find($report->room_item_id);
        $roomitem->total_rusak = $report->total;
        $roomitem->total = $roomitem->total - $roomitem->total_rusak;
        $roomitem->save();
        $report->update([
            'claim' => 2,
        ]);
        return redirect(route('report.index'))->with(['success' => 'data kerusakan barang telah di terima.']);
    }
}
