<?php
namespace App\Http\Controllers;

use App\Models\Dummy;
use App\Models\Item;
use App\Models\Category;

use App\utils\helpers;
use App\Models\Location;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class DummysController extends Controller
{

    //------------ GET ALL Dummys -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Dummy::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $dummys = Dummy::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('room_number', 'LIKE', "%{$request->search}%");
                       
                });
            });
        $totalRows = $dummys->count();
        $dummys = $dummys->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        

       $locations =  Location::where('deleted_at' , '=' , null)->get();

       $category =  Category::where('deleted_at' , '=' , null)->get();
       
        return response()->json([
            'dummys' => $dummys,
            'category'=> $category,
            'locations'=>  $locations,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Dummy -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Dummy::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/dummys/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

            $Dummy = new Dummy;

            $Dummy->en_name = $request['en_name'];
            $Dummy->ar_name = $request['ar_name'];
            $Dummy->image = $filename;
            $Dummy->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Dummy -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Dummy::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Dummy = Dummy::findOrFail($id);
             $currentImage = $Dummy->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/dummys';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/dummys/' . $filename));
 
                 $DummyImage = $path . '/' . $currentImage;
                 if (file_exists($DummyImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($DummyImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/dummys';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/dummys/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 
             Dummy::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'description' => $request['en_name'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Dummy -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Dummy::class);

        Dummy::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\
    
  public function getByCategoryData($name){
    $category = Category::where('name' , $name)->first();

    if($category){
        return $category->id;
    }else {

        $category = Category::where('name' , 'default')->first();
        return $category->id;

    }

  }

    public function insert_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Dummy::class);
        $room_id = $request->room_id;
        $room_number = $request->room_number;
        $major_id = $request->major_id;
        $minor_id = $request->minor_id;
        $detaild_id = $request->detaild_id;
        
        $major_category = $request->major_category;

        $minor_category = $request->minor_category;
        $detailed_categories = $request->detailed_categories;

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $dummy_id) {
            $dummy = Dummy::where('id' ,$dummy_id )->first();
            
            $item = new Item;
            $item->ar_name =   $dummy->item_name;
            $item->room_id = $room_id;
            $item->image = "no-image.png";

            
            $item->room_number = $room_number;
            $item->major_id = $this->getByCategoryData( $dummy->major_category);
            $item->minor_id = $this->getByCategoryData($dummy->minor_category);
            $item->detaild_id =  $this->getByCategoryData($dummy->detailed_categories);
            $item->uuid = $this->generateUUID();
            $item->save();
      

            // $dummy->update([
            //    'status' => 'inserted'
            // ]);
            
            Dummy::whereId($dummy_id)->update([
                'status' => "inserted",
            ]);
        }

        return response()->json(['success' => true]);

    }




        // import Products
        public function import_dummy(Request $request)
        {
            try {
                \DB::transaction(function () use ($request) {
                    $file_upload = $request->file('dummys');
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
     
                        //-- Create New Product
                        foreach ($data as $key => $value) {
                   
                            $Product = new Dummy;
                            $Product->room_name = $value['room_name'] == '' ? null : $value['room_name'];
                            $Product->item_name =  $value['item_name'] == '' ? null : $value['item_name'];
                            $Product->room_number = $value['room_number'] == '' ? null : $value['room_number'];
                            $Product->floor = $value['floor'] == '' ? null : $value['floor'];
                            $Product->status = $value['status'] == '' ? null : $value['status'];
                            $Product->note = $value['note'] == '' ? null : $value['note'];
                            $Product->save();
    
                         
                        }
                     
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




    public function generateUUID(){
        // $room = Room::where('room_id' , $id)->first();
        $items = Item::max('uuid');

        if($items == 0){
            return 1000;
        }
        $uuid =    intval($items) + 1; 

        return $uuid;
    }



    public function delete_by_selection(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'delete', Dummy::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $dummy_id) {
            Dummy::whereId($dummy_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

