<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class RoomsController extends Controller
{

    //------------ GET ALL Rooms -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Room::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $id = $request->id;

        $rooms = Room::where('deleted_at', '=', null)->where('build_id',  $id)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $rooms->count();
        $rooms = $rooms->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'rooms' => $rooms,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Room -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Room::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

        
            $room = Room::max('uuid');
            $Room = new Room;
            if($request['uuid'] ==  ""){
                $Room->uuid =  intval($room) + 1;  ; 
            }else{
                $Room->uuid = $request['uuid'];
            }

            $Room->room_number = $request['room_number'];
            $Room->build_id = $request['build_id'];
            $Room->ar_name = $request['ar_name'];
      
            $Room->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Room -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Room::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Room = Room::findOrFail($id);
      
 
       
             Room::whereId($id)->update([
                'room_number' => $request['room_number'],
                'uuid' => $request['uuid'],
                 'ar_name' => $request['ar_name'],
                 'build_id' => $request['build_id'],
         
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Room -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Room::class);

        Room::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Room::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $room_id) {
            Room::whereId($room_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

