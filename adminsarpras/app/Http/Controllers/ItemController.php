<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Item;
use App\Model\Room;
use App\Model\RoomItem;
use App\Model\Tipe;
use App\Model\Satuan;
use File;
use Image;
use Carbon\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipe = Tipe::all();
        $rooms = Room::all();
        $satuan = Satuan::all();

        return view('admin.items.create', compact('rooms', 'tipe', 'satuan'));
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
            'item' => 'required|string|max:250',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            'tipe_id' => 'required|exists:tipe,id',
            'satuan' => 'required|exists:satuans,id',
            'total' => 'required|integer',
            'room_id' => 'required|exists:rooms,id',
            'merk' => 'required|string',
        ]);

       // Image
        $file = $request->file('image');
        $nama_file = time()."_".$file->getClientOriginalName();
        $image_resize = Image::make($file->getRealPath());
        $image_resize->resize(500, 500);
        $tujuan_upload = 'upload';
        $image_resize->save(public_path('upload/' .$nama_file));
       // End Image

        $time = Carbon::today('Asia/Jakarta');
        $date = $time->toDateString();
        $items = Item::create([
            'item' => $request->item,
            // 'room_id' => $request->room_id,
            'status' => $request->status,
            // 'total' => $request->total,
            'tipe_id' => $request->tipe_id,
            'satuan_id' => $request->satuan,
            'image' => $nama_file,
            'date' => $date,
        ]);


        $roomItem = RoomItem::create([
            'item_id' => $items->id,
            'room_id' => $request->room_id,
            'total' => $request->total,
            'tanggal_barang_masuk' => $request->tanggal_barang_masuk,
            'merk' => $request->merk,
        ]);


        return redirect(route('items.index'))->with(['success' => 'data barang berhasil diinput.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = Item::findOrFail($id);
        return view('admin.items.detail', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = Item::findOrFail($id);
        $rooms = Room::all();
        $tipe = Tipe::all();
        $satuan = Satuan::all();
        return view('admin.items.edit', compact('items', 'rooms', 'tipe', 'satuan'));
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
        // $this->validate($request, [
        //     'item' => 'required|string|max:250',
        //     'status' => 'required|string',
        //     'image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
        //     'tipe_id' => 'required|exists:tipe,id',
        //     'satuan' => 'required|exists:satuans,id',
        //     'total' => 'required|integer',
        //     'room_id' => 'required|exists:rooms,id',
        // ]);

        // dd($request->all());
        $items = Item::findOrFail($id);
        $image = $items->image;

        if ($request->hasFile('image')) {
            !empty($image) ? File::delete(public_path('upload' . $image)):null;
            $image = $this->saveFile($request->item, $request->file('image'));
        }

        $time = Carbon::today('Asia/Jakarta');
        $date = $time->toDateString();

        $items->update([
            'item' => $request->item,
                // 'room_id' => $request->room_id,
            'status' => $request->status,
                // 'total' => $request->total,
            'tipe_id' => $request->tipe_id,
            'satuan_id' => $request->satuan_id,
            'image' => $image,
            'date' => $date,
        ]);
        $roomItem = RoomItem::where('item_id', $items->id);
        $roomItem->update([
            'item_id' => $items->id,
            'room_id' => $request->room_id,
            'total' => $request->total,
            'tanggal_barang_masuk' => $request->tanggal_barang_masuk,
            'merk' => $request->merk,
        ]);
        return redirect(route('items.index'))->with(['success' => 'data barang berhasil diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = Item::findOrFail($id);
        if (!empty($items->image)) {
            File::delete(public_path('upload' . $items->image));
        }
        $items->delete();
        $roomitem = RoomItem::where('item_id', $items->id);
        $roomitem->delete();


        return redirect(route('items.index'))->with(['success' => 'data barang berhasil dihapus.']);
    }

    public function saveFile($item, $image)
    {
        $Images = str_slug($item) . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('upload');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        Image::make($image)->save($path . '/' . $Images);
        return $Images;
    }
}
