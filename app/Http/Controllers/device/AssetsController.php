<?php

namespace App\Http\Controllers\device;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Gd\Decoder;
use App\Models\Item;
use App\Models\Asset;
use App\Models\Room;

use App\Models\Transfear;
use App\Models\Location;
use App\Models\Build;
use App\Models\Category;
use App\Models\Inventorie;
use App\Models\Session;
use App\Exports\InventoriesExport;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\ImageManagerStatic as Image;
class AssetsController extends Controller
{



    public function exportInventory(Request $request , $date){


    
            return Excel::download(new InventoriesExport( $date), 'List_inventories.xlsx');
       

    }


    
    
    public function barcodeone(Request $request ){

        $type = $request->type;
        $id = $request->id;
        if($type == "room"){
            $room =  Room::where('deleted_at', '=', null)->where('id' , $id)->first();
        }else{

            $room  =  Item::where('deleted_at', '=', null)->where('id' , $id)->first();
          
        }
     
        return response()->json([
 
            'ar_name'=> $room->ar_name,
            'uuid'=> $room->uuid
          
        ]);


    }

 


    public function barcode(Request $request , $id){

        $item =  Item::where('deleted_at', '=', null)->where('room_id' , $id)->get(['uuid' , 'id' , 'ar_name']);
        $room =  Room::where('deleted_at', '=', null)->where('id' , $id)->first();
        return response()->json([
            'items' =>   $item ,
            'room_name'=> $room->ar_name,
            'uuid'=> $room->uuid
          
        ]);


    }

    public function getMissedData($session_id){
       return   Session::where('deleted_at', '=', null)->where('item_status' , "missed")->where('session_id' ,$session_id)->count();
    }

    public function listSessions(Request $request){
        
          
            // How many items do you want to display.
            $perPage = $request->limit;
            $pageStart = \Request::get('page', 1);
            // Start displaying items from this number;
            $offSet = ($pageStart * $perPage) - $perPage;
            $order = $request->SortField;
            $dir = $request->SortType;
            $helpers = new helpers();
            $id = $request->room_id;
            $data = array();
            $room = Room::where('deleted_at', '=' , null)->where('uuid' ,   $id )->first();
            $sessions = Inventorie::with('room.floor.location')->where('deleted_at', '=', null)->where('room_id' , $room->id  )->where(function ($query) use ($request) {
                    return $query->when($request->filled('search'), function ($query) use ($request) {
                        return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                            ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                    });
                });
            $totalRows = $sessions->count();
            $sessions = $sessions->offset($offSet)
                ->limit($perPage)
                ->orderBy($order, $dir)
                ->get();


                foreach ($sessions as $session) {

                    $item['id'] = $session->id;
                    $item['start_session_date'] = $session->start_session_date;
                    $item['location'] = $session->room->floor->location->ar_name;
                    $item['floor'] = $session->room->floor->ar_name;
                    $item['room'] = $session->room->ar_name;
                    $item['missed'] = $this->getMissedData($session->id);
                    $data[] = $item;
                    
                }



    
            return response()->json([
                'sessions' => $data,
                'totalRows' => $totalRows,
            ]);
    
      

        
    }
    

    public function assetInfo(Request $request){
        $id = $request->id;
        // $type = $request->type;
        // $slider = Slider::where('deleted_at', '=', null)->where('device' ,$type )->get(['image']);
        $items = Item::with('room.floor.location')->where('deleted_at', '=', null)->where('uuid' ,   $id )->first();

        // $locations = Location::where('deleted_at', '=', null)->get();
        // $Build = Build::where('deleted_at', '=', null)->get();
 
        $room = Room::where('deleted_at', '=', null)->where('build_id' ,$items->room->floor->id)->get();
    

        return response()->json([
            'asset' =>   $items ,
            // 'locations' => $locations,
            // 'floors'=> $Build , 
            'rooms' => $room ,

        ]);
 
    }

    public function roomInfo(Request $request){
        $id = $request->id;

        $room = Room::with('floor.location'   )->where('deleted_at', '=' , null)->where('uuid' ,   $id )->first();

        $items = Item::where('deleted_at', '=' , null)->where('room_id' ,   $room->id )->get();
        return response()->json([
            'room' =>   $room ,
            'assets' =>   $items ,
        ]);


    }


    public function insertItems($session_id){

    }



    public function trans(Request $request){

         $oldroom = $request['room_id'];
         $item_id = $request['item_id'];
    
       $items = Item::with('room')->where('deleted_at', '=', null)->where('uuid' ,  $item_id )->first();
        $Transfear = new Transfear;
        $Transfear->item_id = $item_id;
        $Transfear->old_room_id = $items->room_id;
        // $Transfear->old_location_id = $request['old_location_id'];
        // $Transfear->old_floor_id = $request['old_floor_id'];
        // $Transfear->user_id = $request['user_id'];
        // $Transfear->inventorie = $request['inventorie'];
        // $Transfear->date = $request['date'];
        $Transfear->save();
  

        return response()->json([
            'transfear' =>    $Transfear,
            ]); 

    }


    public function update_items(Request $request){


        $inventorie =  Inventorie::where('deleted_at', '=' , null)->where('session_status' , 'open')->first();

        // if($inventorie ){
        //   $Inventore_id = $inventorie->id;

        // } 
 
        $uuid =  $request->item_id;
        $item = Item::where('uuid' , $uuid )->first();


        if(!$item){


            return response()->json([
                'status' =>  "not_found" ,
                ]); 
        }


        $id = $item->id;

         $haveItems  = Session::where('session_id' , $inventorie->id )->where('item_status' , 'pending')->where('item_id' , $item->id)->first();


        if( $haveItems){


            Session::where( "item_id" , $id)->where('session_id' , $inventorie->id )->update([
                'item_status' => "exist",
            ]); 


            return response()->json([
                'status' =>  "updated" ,
                ]); 



        }else{

         
        
         return response()->json([
            'status' =>  "trans" ,
            ]); 


        }

     





        // return response()->json([
        //     'status' =>  "updated" ,
        //     ]); 



    }

    public function GetRoomItems($id){


        $room = Room::where('deleted_at', '=' , null)->where('uuid' ,   $id )->get();
        $data = array();
       
        foreach ($room as $asset) {
            $item['id'] = $asset->id;
            $item['ar_name'] = $asset->ar_name;
            $item['status'] = $asset->status;
            $firstimage = explode(',', $asset->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }
    }


    public function updateRoom(Request $request){

        $room_id = $request['new_room_id'];
        $item_id = $request['item_id'];
        $uuid = $request['uuid'];
 

      if($uuid == "yes"){

        $room =  Room::where('uuid' , $room_id)->first();
        $room_id  = $room->id;
      }


  




        $asset  = Item::with('room')->where('id' ,$item_id )->first();
        $asset_uuid =  $asset->uuid;
     
        if(!$asset){
            return response()->json([
                'status' =>  "not_updated" ,
                ]); 
        }


        $user = Auth::user();
        $Transfear = new Transfear;

        $Transfear->item_id = $item_id ;
        $Transfear->old_room_id = $asset->room->id;
        $Transfear->user_id = $user->id;
        // $Transfear->ar_name = $request['ar_name'];
        // $Transfear->image = $filename;
        $Transfear->save();
        // 'item_id', 'old_room_id',  
        // 'old_location_id', 
        // 'old_floor_id', 
        // 'user_id', 
        // 'inventorie', 
        // 'date', 

       Item::whereId( $item_id )->update([

            'room_id' => $room_id ,
 
         ]);

        //  return response()->json(['status' => "success" ,  'message'=>  "ddd"  ], 200);

         return response()->json([
            'status' =>  "updated" ,
            ]); 



    }

    

    public function getRoom(Request $request){
        $dropDown = $request->type;

        $room = Room::where('build_id' , $dropDown)->where('deleted_at' , '=' , null)->get();

        return response()->json([
         'rooms' =>  $room ,
         ]); 
        

}



    public function getDrop(Request $request){
               $dropDown = $request->type;

             $floor = Build::where('location_id' , $dropDown)->where('deleted_at' , '=' , null)->get();

               return response()->json([
                'floors' =>  $floor ,
                ]); 
               

    }

    public function  updateImage(Request $request){
        $helpers = new helpers();
       

         $id_item = $request['id'];
         
         $item = Item::where('uuid' , $id_item )->first();
        
         $currentAvatar = $item->image;


         $image = $request->file('avatar');
         $path = public_path() . '/images/items';
         $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

        //  $image_resize = Image::make($image->getRealPath());
         // $image_resize->resize(128, 128);
         $image->move($path, $filename);
        //  $image_resize->save(public_path('/images/items/' . $filename));

         $userPhoto = $path . '/' . $currentAvatar;
         if (file_exists($userPhoto)) {
             if ($item->image != 'no_avatar.png') {
                 @unlink($userPhoto);
             }
         }

         // $filename = $currentAvatar;
   

        // return $filename;


 Item::whereId($item->id)->update([

     'image' => $filename,
   
 ]);




 return response()->json(['status' => "success" ,  'message'=> $filename   ], 200);





    }

    public function session(Request $request){
    
        $status = $request['status'];
        $room_id = $request['room_id'];
        $user_id = Auth::user();
        $Inventore_id = 0;
        // $inventorie =  Inventorie::where('deleted_at', '=' , null)->where('session_status' , 'open')->first();
        if($status == "open"){

             $inventorie =  Inventorie::where('deleted_at', '=' , null)->where('session_status' , 'open')->first();
            if($inventorie ){
              $Inventore_id = $inventorie->id;
            
              
              }else{
                $rooma = Room::where('uuid' , $room_id )->first();
                $Inventore = new Inventorie;
                $Inventore->start_session_date = date('d-m-Y');
                $Inventore->session_status = "open";
                $Inventore->room_id = $rooma->id;
                $Inventore->user_id =    $user_id->id;  //TODOLIST replace with the request user id 
                $Inventore->save();
                $Inventore_id = $Inventore->id;


                $room = Room::with('items')->where('deleted_at', '=' , null)->where('uuid' ,   $room_id )->first();
       
 
                foreach ($room->items as $asset) {
     
                    $session = new Session;
                    $session->item_status = "pending";
                    $session->item_id = $asset->id;
                    $session->session_id = $Inventore_id;
                    $session->save();
    
                }



            } 
 



            // $space = new Session();
            // $space->fill($data);
            // $space->save();


            // $this->insertItems($Inventore->id);
          


        }else{

              $inventorie =  Inventorie::where('deleted_at', '=' , null)->where('session_status' , 'open')->first();
             
              if(!$inventorie){
                return response()->json(['status' => false , "message"=> "ff" ] , 404);
              }
              $Inventore_id = $inventorie->id;
            

            Inventorie::whereId($Inventore_id)->update([
                'session_status' => "closed",
                'end_session_date' =>  date('d-m-Y')
                
            ]); 

            Session::where('session_id' ,  $Inventore_id)->where( 'item_status' , 'pending')->update([
                'item_status' => "missed",

            ]); 

        }

 
        $session_items =  Session::with('item')->where('deleted_at', '=' , null)->where('session_id' , $Inventore_id)->get();

   

    //    $room_idd = $inventorie->room_id;


         
        return response()->json([
           'assets' =>  $session_items ,
     
              ]);
        // Inventore::where('deleted_at', '=' , null)->

        // Session::



    }


    public function inventory(Request $request){

        $id = $request->id;

        $room = Room::where('deleted_at', '=' , null)->where('uuid' ,   $id )->first();

        $items = Item::where('deleted_at', '=' , null)->where('room_id' ,   $room->id )->get();
        return response()->json([
            'room' =>   $room ,
            'assets' =>   $items ,
        ]);
    }



}
