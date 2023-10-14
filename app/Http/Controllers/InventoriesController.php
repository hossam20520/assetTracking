<?php
namespace App\Http\Controllers;

use App\Models\Inventorie;
use App\Models\Session;
use App\Models\Item;
use App\Models\Room;

use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class InventoriesController extends Controller
{

    //------------ GET ALL Inventories -----------\


    


    public function data(Request $request , $id)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Inventorie::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $inventories = Session::where('deleted_at', '=', null)->where('session_id' , $id)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $inventories->count();
        $inventories = $inventories->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


            

            $data = array();
            foreach ($inventories as   $va) {

                 $asset =  Item::where('id' ,  $va->item_id)->first();
                 $item['id'] =  $va->id;
                 $item['item_status'] =  $va->item_status;
                 $item['item'] =  $asset->ar_name;
                 $item['uuid'] =  $asset->uuid;
                 $item['session_status'] =  $va->session_status;
                //  $item['location'] =  $va->session;
                //  $item['room'] =  $va->room;
                //  $item['floor'] =  $va->floor;
                 $data[] = $item;
            }

        return response()->json([
            'inventories' => $data,
            'totalRows' => $totalRows,
        ]);

    }

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Inventorie::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $inventories = Inventorie::with('user')->where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $inventories->count();
        $inventories = $inventories->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


            

            $data = array();
            foreach ($inventories as   $va) {
                $room = Room::with('floor')->where('id' , $va->room_id )->first();
                $item['id'] =  $va->id;
                 $item['start_session_date'] =  $va->start_session_date;
                 $item['end_session_date'] =  $va->end_session_date;
                 $item['session_status'] =  $va->session_status;
                 $item['location'] =  $room->floor->location->ar_name;
                 $item['room'] =  $room->ar_name;
                 $item['email'] =  $va->user->email;
                 $item['floor'] =  $room->floor->ar_name;
                 $data[] = $item;
            }

        return response()->json([
            'inventories' => $data,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Inventorie -------------\

    public function store(Request $request)
    {
        $this->authorizeForUser($request->user('api'), 'create', Inventorie::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/inventories/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

            $Inventorie = new Inventorie;

            $Inventorie->en_name = $request['en_name'];
            $Inventorie->ar_name = $request['ar_name'];
            $Inventorie->image = $filename;
            $Inventorie->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Inventorie -------------\

     public function update(Request $request, $id)
     {
 
         $this->authorizeForUser($request->user('api'), 'update', Inventorie::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Inventorie = Inventorie::findOrFail($id);
             $currentImage = $Inventorie->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/inventories';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/inventories/' . $filename));
 
                 $InventorieImage = $path . '/' . $currentImage;
                 if (file_exists($InventorieImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($InventorieImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/inventories';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/inventories/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 
             Inventorie::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'description' => $request['en_name'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Inventorie -----------\

    public function destroy(Request $request, $id)
    {
        $this->authorizeForUser($request->user('api'), 'delete', Inventorie::class);

        Inventorie::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'delete', Inventorie::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $inventorie_id) {
            Inventorie::whereId($inventorie_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

