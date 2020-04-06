<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\RoomItem;
use App\Model\Room;
use App\Model\Report;
use PDF;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room = Room::all();
        return view('admin.laporan.index', compact('room'));
    }

    public function print($id)
    {
        $room = Room::find($id);

        $it = [];
        $ite = $room->roomitem;
        foreach ($ite as $item) {
            array_push($it, $item->item);

        }
        // $report = Report::find($ite->roomitem->)
        // error_reporting(E_ALL ^ E_DEPRECATED);
        $pdf = PDF::loadview('admin.laporan.print', compact('it', 'room'));
        return $pdf->stream();
    }
}
