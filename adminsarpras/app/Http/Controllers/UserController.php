<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\Users;
use App\Model\Item;
use App\Model\Room;
use App\Model\RoomItem;
use App\Model\Report;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function login(Request $request){
        $users = users::where('email', $request->email)->first();
        if($users){
            if(Hash::check($request->password, $users->password)){
                if($users->status == "0"){
                    $data = [
                        'message' => 'Please call admin for verified',
                        'code' => '0',
                        'id' => '0'
                    ];
                    return response()->json($data);
                }else{
                    if($users->roles == '1'){
                        $data = [
                            'message' => 'Please login with website',
                            'code' => '0',
                            'id' => '0'
                        ];
                        return response()->json($data);
                    }else if($users->roles == '0'){
                        $data = [
                            'message' => 'Welcome ' . $users->nama,
                            'code' => '1',
                            'id' => $users->id,
                            'email' => $users->email,
                        ];
                        session()->put('login', true);
                        session()->put('id', $users->id);
                        return response()->json($data);
                    }
                }
            }else{
                $data = [
                    'message' => 'Password yang anda masukkan salah',
                    'code' => '0',
                    'id' => '0'
                ];
                return response()->json($data);
            }
        }
        else{
            $data = [
                'message' => 'Email tidak terdaftar',
                'code' => '0',
                'id' => '0'
            ];
            return response()->json($data);
        }
    }
    public function register(Request $request){

        if($request->password === $request->cpassword){
            if(Users::where('email', $request->email)->first()){
                $data = [
                    'message' => 'Email sudah terdaftar !',
                    'code' => '0',
                    'id' => '0'
                ];
                return response()->json($data);
            }else{
                $pass = Hash::make($request->password);
                $user = Users::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $pass,
                    'room_id' => $request->room,
                    'status' => "0",
                    'roles' => '0'
                ]);
                $data = [
                    'message' => 'Berhasil mendaftar !',
                    'code' => '1',
                    'id' => $user->id
                ];
                return response()->json($data);
            }
        }else{
            $data = [
                'message' => 'Kombinasi password yang anda masukkan salah !',
                'code' => '0',
                'id' => '0'
            ];
            return response()->json($data);
        }

    }
    public function show($id){
        $user = Users::find($id);
        $room = Room::find($user->room_id);
        $roomItem = RoomItem::where('room_id', $room->id)
                    ->join('items', 'items.id', '=', 'roomitem.item_id')
                    ->join('rooms', 'rooms.id', '=', 'roomitem.room_id')
                    ->join('tipe', 'items.tipe_id', '=', 'tipe.id')
                    ->select('items.item', 'roomitem.total', 'rooms.room', 'items.id', 'items.image', 'items.status', 'tipe.tipe')
                    ->get();
        
        // $items = [];
        // foreach ($roomItem as $r) {
        //     $r->item->total = $r->total;
        //     $r->item->room_id = $r->room->room;
        //     array_push($items, $r->item);
        // }
        return response()->json($roomItem);
    }
    public function editItem(Request $request){
        
        if($request->img == "0"){
            if($request->item != null && $request->total != null){
                $today = Carbon::today('Asia/Jakarta');
                    $date = $today->toDateString();
                    $item = Item::find($request->id);
                    $item->item = $request->item;
                    $item->date = $date;
                $item->save();
                $roomitem = RoomItem::where('item_id', $item->id)->first();
                    $roomitem->total = $request->total;
                $roomitem->save();
                $data = [
                    'message' => 'Data berhasil diubah !',
                    'code' => '1',
                    'id' => '0'
                ];
            }else{
                $data = [
                    'message' => 'Harap lengkapi inputan !',
                    'code' => '0',
                    'id' => '0'
                ];
            }
        } else{
            if($request->item != null && $request->total != null){

                $file = $request->file('file');
                    $nama_file = time()."_".$file->getClientOriginalName();
                    
                    $image_resize = Image::make($file->getRealPath());              
                    $image_resize->resize(500, 500);
                    $tujuan_upload = 'upload';
                    $image_resize->save(public_path('upload/' .$nama_file));
                    
                // Date
                    $today = Carbon::today('Asia/Jakarta');
                    $date = $today->toDateString();
                    
                // EndDate
                
                    $item = Item::find($request->id);
                        $item->item = $request->item;
                        $item->date = $date;
                        $item->image = $nama_file;
                    $item->save();
                    $roomitem = RoomItem::where('item_id', $item->id)->first();
                        $roomitem->total = $request->total;
                    $roomitem->save();
                $data = [
                    'message' => 'Data berhasil diubah !',
                    'code' => '1',
                    'id' => '0'
                ];
                

            }else{
                $data = [
                    'message' => 'Harap lengkapi inputan !',
                    'code' => '0',
                    'id' => '0'
                ];
            }
        }
        return response()->json($data);
    }
    public function logout(){
        session()->forget('id');
        session()->forget('login');
        $data = [
            'message' => 'Berhasil Logout !',
            'code' => '1',
            'id' => '0'
        ];
        return response()->json($data);
    }
    public function getItem($id){
        $item = Item::find($id);
        $item->room = $item->roomItem->room->room;
        $item->total = $item->roomItem->total;
        return response()->json($item);
    }
    public function addReport(Request $request){
        
        if($request->file || $request->reason || $request->id_item){
            // Upload Photo
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(500, 500);
            $tujuan_upload = 'upload';
            $image_resize->save(public_path('upload/' .$nama_file));
            // End
            $item = Item::find($request->id_item);
            
            $roomitem = $item->roomItem;
            

            Report::create([
                'room_item_id' => $roomitem->id,
                'reason' => $request->reason,
                'user_id' => $request->id,  
                'claim' => "1",
                'img' => $nama_file,
                'total' => $request->total
            ]);
            $data = [
                'message' => 'Berhasil menambahkan laporan !',
                'code' => '1',
                'id' => '0'
            ];
        }else{
            $data = [
                'message' => 'Harap isi semua inputan !',
                'code' => '0',
                'id' => '0'
            ];
        }   
        
        return response()->json($data );
    }
    public function checkSession(Request $request){
            $data = [
                'message' => 'Selamat datang',
                'code' => '1',
                'id' => $request->id
            ];
        
        return response()->json($data);
    }
    public function room(){
        $room = Room::all();
        $rooms = [];
        foreach ($room as $r ) {
            if($r->user){
                if($r->user->status == "0"){
                    array_push($rooms, $r);    
                }
            }else{
                array_push($rooms, $r);
            }
        }
        
        return response()->json($rooms);
    }
    public function barcode($id, $idUser){
        $item = Item::find($id);
        $user = Users::find($idUser);
        $ada = 0;
        $id;

        if($user->room){
            foreach ($user->room->roomItem as $i) {
                if($item){
                    if($item->id  == $i->item[0]->id){
                        $ada = 1;
                        $id = $i->item[0]->id;
                    }else{

                    }
                }else{
                    $data = [
                        'message' => "Tidak ada barang !",
                        'code' => '0',
                        'id' => '0',
                        'item' => ""
                    ];
                }
            }
            if($ada == 1){
                $data = [
                    'message' => 'Berhasil',
                    'code' => '1',
                    'id' => $id,
                    'item' => $item->item
                ];
                
            }else{
                $data = [
                    'message' => "Tidak memiliki akses terhadap menu !",
                    'code' => '0',
                    'id' => '0',
                    'item' => ""
                ];
            }
        }else{
            $data = [
                "message" => "Tidak memiliki akses terhadap menu ini !",
                "code" => "0",
                'id' => "0",
                'item' => ""
            ];
        }
        return $data;

    }
    public function getAllReport(Request $request){
        $reports = Report::where("user_id", $request->id)->orderBy('created_at', 'ASC')->limit(5)->get();
        
        foreach ($reports as $report) {
            $report->room = $report->roomItem->room->room;
            $report->item = $report->roomItem->item->item;
            
            
            $report->date = $report->created_at->toDateString();    
            if($report->claim == "1"){
                $report->claim = "Belum Konfirmasi";
            }else if($report->claim == "2"){
                $report->claim = "Diterima";
            }else{
                $report->claim = "Ditolak";
            }
        }
        return response()->json($reports);
        
    }
    public function getOneReport(Request $request){
        $report = Report::find($request->id);
        $report->room = $report->roomItem->room->room;
        $report->item = $report->roomItem->item->item;
        $report->date = $report->created_at->toDateString();
        if($report->claim == "1"){
            $report->claim_text = "Belum Konfirmasi";
        }else if($report->claim == "2"){
            $report->claim_text = "Diterima";
        }else{
            $report->claim_text = "Ditolak";
        }
        return response()->json($report);
    }
}
