<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Location;
use App\Models\Build;
use App\Models\Room;
 
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ItemsController extends Controller
{

    //------------ GET ALL Items -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Item::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        $id = $request->id;

        $items = Item::with('Major' , 'room' , 'Minor'  , 'detailed')->where('deleted_at', '=', null)->where('room_id' , $id)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('uuid', '=', "{$request->search}");
                       
                });
            });
        $totalRows = $items->count();
        $items = $items->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


              $data = array();
            
            foreach ($items as $asset) {

            
                $item['id'] = $asset->id;
                $item['ar_name'] = $asset->ar_name;
                $item['uuid'] = $asset->uuid;
                // $item['orical_number'] = $asset->orical_number;
                $item['major'] =   $asset->Major->name;
                $item['minor'] =   $asset->Minor->name;
                $item['detaild'] = $asset->detailed->name;

                $item['major_id'] =   $asset->major_id;
                $item['minor_id'] =   $asset->minor_id;
                $item['detaild_id'] = $asset->detaild_id;


                $item['room_number'] = $asset->room_number;
                $item['orical_number'] = $asset->orical_number;
                $firstimage = explode(',', $asset->image);
                $item['image'] = $firstimage[0];
                $data[] = $item;
            }



            $categories = Category::where('deleted_at', null)->get(['id', 'name']);
 
            
            
            $roo = Item::with(  'room'   )->where('deleted_at', '=', null)->where('room_id' , $id)->first();

        return response()->json([
            'items' => $data,
            'totalRows' => $totalRows,

            'room'=>  $roo->room ,

            'categories' => $categories,
        ]);

    }


    public function GetLocationID($id_location, $location_name){
 

        $uniqueKey = ['uuid' => $id_location]; // Change this to your actual unique key

        // Data to update or insert
        $data = [
        'ar_name' => $location_name,
        // Add other fields you want to update or insert here
        ];

        // Perform the create or update operation
        $location =  Location::updateOrInsert($uniqueKey, $data);

 

    }


    public function GetBuildID($room_floar_id, $location_name , $room_location_id){

       

          $location =  Location::where('uuid' , $room_location_id )->first();
      
        $uniqueKey = ['uuid' => $room_floar_id]; // Change this to your actual unique key

        // Data to update or insert
        $data = [
        'ar_name' => $location_name,
        'location_id'=>  $location->id
        // Add other fields you want to update or insert here
        ];

        // Perform the create or update operation
         Build::updateOrInsert($uniqueKey, $data);
 

     }

  

     public function insertMajor($Major_name  , $majour_uuid   ){
        $uniqueKey = ['uuid' =>  $majour_uuid ]; // Change this to your actual unique key

        // Data to update or insert
        $data = [
        'name' => $Major_name,
        'code'=>  $Major_name,
        'uuid'=>   $majour_uuid ,
        // Add other fields you want to update or insert here
        ];

        // Perform the create or update operation
        Category::updateOrInsert($uniqueKey, $data);


     }


    //  $value['room_name'] , $value['room_uuid'] , $value['orical_number'] , $value['room_number'] , $value['room_room_flloar_uuid']
     public function SaveRoom($room_name, $room_uuid , $orical_number , $room_number ,$room_room_flloar_uuid  ){
 
      $location =  Build::where('uuid' , $room_room_flloar_uuid )->first();
    
      $uniqueKey = ['uuid' => $room_uuid]; // Change this to your actual unique key

      // Data to update or insert
      $data = [
      'ar_name' => $room_name,
      'uuid' => $room_uuid,
      'room_number' => $room_number,
      'build_id'=>  $location->id
      // Add other fields you want to update or insert here
      ];

      // Perform the create or update operation
      Room::updateOrInsert($uniqueKey, $data);


   }

//    $this->insertItem($value['item_name'] ,$value['major_uuid']  ,  $value['minor_uuid']  , $value['detaild_uuid']  , $value['orical_number']  );

   public function insertItem($item_name,  $room_uuid ,  $item_uuid  , $major_uuid , $minor_uuid , $detaild_uuid ,$orical_number  ){
 
    $room =  Room::where('uuid' , $room_uuid )->first();


    $major_uuid =  Category::where('uuid' , $major_uuid )->first();
    $minor_uuid =  Category::where('uuid' , $minor_uuid )->first();
    $detaild_uuid =  Category::where('uuid' , $detaild_uuid )->first();
    $uniqueKey = ['uuid' => $item_uuid]; // Change this to your actual unique key

    // Data to update or insert
    $data = [
    'ar_name' => $item_name,
    'major_id' =>$major_uuid->id,
    'minor_id' => $minor_uuid->id,
    'detaild_id'=>  $detaild_uuid->id,
    'orical_number'=> $orical_number,
    'room_id'=> $room->id,
    'image'=>  "no-image.png",
    // Add other fields you want to update or insert here
    ];

    // Perform the create or update operation
    Item::updateOrInsert($uniqueKey, $data);


 }



//    

        // import Products
        public function import_items(Request $request)
        {
            try {
                \DB::transaction(function () use ($request) {
                    $file_upload = $request->file('items');
                    $ext = pathinfo($file_upload->getClientOriginalName(), PATHINFO_EXTENSION);
                    if ($ext != 'csv') {
                        return response()->json([
                            'msg' => 'must be in csv format',
                            'status' => false,
                        ]);
                    } else {
                        $data = array();
                        $rowcount = 0;
                        if (($handle = fopen($file_upload, "r")) !== false) {
    
                            $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
                            $header = fgetcsv($handle, $max_line_length);
                            $header_colcount = count($header);
                            while (($row = fgetcsv($handle, $max_line_length)) !== false) {
                                $row_colcount = count($row);
                                if ($row_colcount == $header_colcount) {
                                    $entry = array_combine($header, $row);
                                    $data[] = $entry;
                                } else {
                                    return null;
                                }
                                $rowcount++;
                            }
                            fclose($handle);
                        } else {
                            return null;
                        }
    
    
                        // $warehouses = Warehouse::where('deleted_at', null)->pluck('id')->toArray();
    
                        //-- Create New Product
                        foreach ($data as $key => $value) {


                            
                             
                          $this->GetLocationID($value['location_uuid'] , $value['location_name']);
                          $this->GetBuildID($value['room_floar_uuid'] , $value['room_floar'] , $value['room_floar_join_location_uuid']);
                            
                          $this->SaveRoom($value['room_name'] , $value['room_uuid'] , $value['orical_number'] , $value['room_number'] , $value['room_floar_join_room'] );
                            
                         
                           $this->insertMajor($value['major_name'] ,$value['major_uuid']);

                           $this->insertMajor($value['minor_name'] ,$value['minor_uuid']);

                           $this->insertMajor($value['detaild_name'] ,$value['detaild_uuid'] );


                           $this->insertItem($value['item_name'] ,  $value['room_uuid'] ,  $value['item_uuid'] ,   $value['major_uuid']  ,  $value['minor_uuid']  , $value['detaild_uuid']  , $value['orical_number']  );


                             
                        }



                        // if ($warehouses) {
                        //     product_warehouse::insert($product_warehouse);
                        // }
                    }
                }, 10);
                return response()->json([
                    'status' => true,
                ], 200);
    
            } catch (ValidationException $e) {
                return response()->json([
                    'status' => false,
                    'msg' => 'error',
                    'errors' => $e->errors(),
                ]);
            }
    
        }

    //---------------- STORE NEW Item -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Item::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                // $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/items/' . $filename));

            } else {
                $filename = 'no-image.png';
            }


            
            $items = Item::max('uuid');



            $Item = new Item;
            $Item->ar_name = $request['ar_name'];
            $Item->room_id = $request['room_id'];
 


            if($request['uuid'] ==  ""){
                $Item->uuid =  intval($items) + 1; 
            }else{
                $Item->uuid = $request['uuid'];
            }

      
            $Item->orical_number = $request['orical_number'];
            $Item->room_number = $request['room_number'];
            $Item->major_id = $request['major_id'];
            $Item->minor_id = $request['minor_id'];
            $Item->detaild_id = $request['detaild_id'];
            
          
            $Item->image = $filename;
            $Item->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Item -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Item::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Item = Item::findOrFail($id);
             $currentImage = $Item->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/items';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                //  $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/items/' . $filename));
 
                 $ItemImage = $path . '/' . $currentImage;
                 if (file_exists($ItemImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($ItemImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/items';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/items/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
     
     
     
             Item::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'room_id' => $request['room_id'],
                 'category_id' => $request['category_id'],
                 'uuid' => $request['uuid'],
          
                 'orical_number' => $request['orical_number'],
                 'room_number' => $request['room_number'],
                 'major_id' => $request['major_id'],
                 'minor_id' => $request['minor_id'],
                 'detaild_id' => $request['detaild_id'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Item -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Item::class);

        Item::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Item::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $item_id) {
            Item::whereId($item_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

