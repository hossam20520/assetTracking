<?php
namespace App\Http\Controllers;
use App\Exports\AssetsExport;
use App\Exports\ItemsExport;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Category;
use App\Models\Group;
use App\Models\Client;
 
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use \Gumlet\ImageResize;
use App\Models\Item;
use App\Models\Room;
use App\Models\Build;
 
 

class AssetsController extends BaseController
{
    public function index(request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Asset::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        // Filter fields With Params to retrieve
        $columns = array(0 => 'ar_name', 1 => 'en_name' );
        $param = array(0 => 'like', 1 => '='   );
        $data = array();

        $assets = Item::with('room.floor.location'  )->where('deleted_at', '=', null);

        //Multiple Filter
        $Filtred = $helpers->filter($assets, $columns, $param, $request)
        // Search With Multiple Param
            ->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('assets.ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('assets.en_name', 'LIKE', "%{$request->search}%");
                        
                   
                });
            });
        $totalRows = $Filtred->count();
        $assets = $Filtred->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        foreach ($assets as $asset) {

            
            $item['id'] = $asset->id;
            $item['ar_name'] = $asset->ar_name;
            $item['orical_number'] = $asset->orical_number;
            
            $item['uuid'] = $asset->uuid;
            $item['room'] = $asset->room->ar_name;
            $item['location'] = $asset->room->floor->location->ar_name;
            $firstimage = explode(',', $asset->image);
            $item['image'] = $firstimage[0];
            $data[] = $item;
        }

 

        return response()->json([
 
            'assets' => $data,
            'totalRows' => $totalRows,
        ]);
    }

    //-------------- Store new  Asset  ---------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Asset::class);

        try {
            // $this->validate($request, [
            //     'ar_name' => 'required',
            //     'location_id' => 'required',
       
            // ]);



 


            \DB::transaction(function () use ($request) {
                 
                $latestRecord = Item::where('deleted_at' , '=' , null)->first();
                //-- Create New Asset
                $Asset = new Item;
                $Asset->ar_name = $request['ar_name'];
               
                $Asset->room_id = $request['room_id'];
                $Asset->orical_number = $request['orical_number'];
                $Asset->uuid = intval($latestRecord->uuid) + 1;
                $Asset->major_id = $request['major_id'];
                $Asset->minor_id = $request['minor_id'];
                $Asset->detaild_id = $request['detaild_id'];
                
   
                if ($request['images']) {
                    $files = $request['images'];
                    foreach ($files as $file) {
                        // $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                       
                        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path']));
                      
                        // $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/items/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                    $filename = implode(",", $images);

                    $firstimage = explode(',', $filename);
                    $filename  = $firstimage[0];

                    // $filename = implode(",", $images);
                } else {
                    $filename = 'no-image.png';
                }

                $Asset->image = $filename;
                $Asset->save();

  

            }, 10);

            return response()->json(['success' => true]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'msg' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }

    }

    //-------------- Update Asset  ---------------\
    //-----------------------------------------------\

    public function update(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'update', Asset::class);
        try {
            $this->validate($request, [
  
                'ar_name' => 'required',
       
        
            ] );

            \DB::transaction(function () use ($request, $id) {

                $Asset = Item::where('id', $id)
                    ->where('deleted_at', '=', null)
                    ->first();
 
                
                // $location = $Asset->room->floor->location;
                // $location->id =  $request['location_id'];
                // $location->save();  
                // $floor = $Asset->room->floor;
                // $floor->id = $request['room_id'] ;
                // $floor->save();
                // $Asset->ar_name = $request['ar_name'];
  
                $Asset->room_id = $request['room_id'];
                $Asset->orical_number = $request['orical_number'];
                $Asset->room_number = $request['room_number'];
                $Asset->major_id = $request['major_id'];
                $Asset->minor_id = $request['minor_id'];
                $Asset->detaild_id = $request['detaild_id'];

                // $Asset->detaild_id = $request['detaild_id'];
                // $floor = $Asset->room->floor;
                // $floor->id = $request['floor_id'];
                // $floor->save();

 
                if ($request['images'] === null) {

                    if ($Asset->image !== null) {
                        foreach (explode(',', $Asset->image) as $img) {
                            $pathIMG = public_path() . '/images/items/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $filename = 'no-image.png';
                } else {
                    if ($Asset->image !== null) {
                        foreach (explode(',', $Asset->image) as $img) {
                            $pathIMG = public_path() . '/images/items/' . $img;
                            if (file_exists($pathIMG)) {
                                if ($img != 'no-image.png') {
                                    @unlink($pathIMG);
                                }
                            }
                        }
                    }
                    $files = $request['images'];
                    foreach ($files as $file) {
                        // $fileData = ImageResize::createFromString(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path'])));
                        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file['path']));
                      
                        // $fileData->resize(200, 200);
                        $name = rand(11111111, 99999999) . $file['name'];
                        $path = public_path() . '/images/items/';
                        $success = file_put_contents($path . $name, $fileData);
                        $images[] = $name;
                    }
                  
                    $filename = implode(",", $images);

                    $firstimage = explode(',', $filename);
                    $filename  = $firstimage[0];

                }

                $Asset->image = $filename;
                $Asset->save();

            }, 10);

            return response()->json(['success' => true]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'msg' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }

    }

    //-------------- Remove Asset  ---------------\
    //-----------------------------------------------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Asset::class);

        \DB::transaction(function () use ($id) {

            $Asset = Item::findOrFail($id);
            $Asset->deleted_at = Carbon::now();
            $Asset->save();

            foreach (explode(',', $Asset->image) as $img) {
                $pathIMG = public_path() . '/images/items/' . $img;
                if (file_exists($pathIMG)) {
                    if ($img != 'no-image.png') {
                        @unlink($pathIMG);
                    }
                }
            }

   

        }, 10);

        return response()->json(['success' => true]);

    }


      //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Asset::class);

        \DB::transaction(function () use ($request) {
            $selectedIds = $request->selectedIds;
            foreach ($selectedIds as $asset_id) {

                $Asset = Item::findOrFail($asset_id);
                $Asset->deleted_at = Carbon::now();
                $Asset->save();

                foreach (explode(',', $Asset->image) as $img) {
                    $pathIMG = public_path() . '/images/items/' . $img;
                    if (file_exists($pathIMG)) {
                        if ($img != 'no-image.png') {
                            @unlink($pathIMG);
                        }
                    }
                }

            
            }

        }, 10);

        return response()->json(['success' => true]);

    }

    //-------------- Export All Asset to EXCEL  ---------------\

    public function export_Excel(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Asset::class);




        return Excel::download(new ItemsExport, 'List_Assets.xlsx');
    }




    //--------------  Show Asset Details ---------------\
    public function Get_Assets_Details(Request $request, $id)
    {

        // $this->authorizeForUser($request->user('api'), 'view', Asset::class);

        $Asset = Asset::with('Category' , 'Group' , 'Client' , 'Location')->where('deleted_at', '=', null)->findOrFail($id);
 

        $item['id'] = $Asset->id;
        $item['ar_name'] = $Asset->ar_name;
        $item['en_name'] = $Asset->en_name;
        $item['category'] = $Asset->Category->name;
        $item['group'] = $Asset->Group->ar_name;
        $item['client'] = $Asset->Client->name;
        $item['location'] = $Asset->Location->getFormattedCategories();


             


   
        if ($Asset->image != '') {
            foreach (explode(',', $Asset->image) as $img) {
                $item['images'][] = $img;
            }
        }

        $data[] = $item;

        return response()->json($data[0]);

    }

    //------------ Get Assets By Warehouse -----------------\

    public function Assets_by_Warehouse(request $request, $id)
    {
        $data = [];
        $asset_warehouse_data = asset_warehouse::with('warehouse', 'Asset', 'assetVariant')
            ->where('warehouse_id', $id)
            ->where('deleted_at', '=', null)
            ->where(function ($query) use ($request) {
                if ($request->stock == '1') {
                    return $query->where('qte', '>', 0);
                }
            })->get();

        foreach ($asset_warehouse_data as $asset_warehouse) {

            if ($asset_warehouse->asset_variant_id) {
                $item['asset_variant_id'] = $asset_warehouse->asset_variant_id;
                $item['code'] = $asset_warehouse['assetVariant']->name . '-' . $asset_warehouse['asset']->code;
                $item['Variant'] = $asset_warehouse['assetVariant']->name;
            } else {
                $item['asset_variant_id'] = null;
                $item['Variant'] = null;
                $item['code'] = $asset_warehouse['asset']->code;
            }

            $item['id'] = $asset_warehouse->asset_id;
            $item['name'] = $asset_warehouse['asset']->name;
            $item['barcode'] = $asset_warehouse['asset']->code;
            $item['Type_barcode'] = $asset_warehouse['asset']->Type_barcode;
            $firstimage = explode(',', $asset_warehouse['asset']->image);
            $item['image'] = $firstimage[0];

            if ($asset_warehouse['asset']['unitSale']->operator == '/') {
                $item['qte_sale'] = $asset_warehouse->qte * $asset_warehouse['asset']['unitSale']->operator_value;
                $price = $asset_warehouse['asset']->price / $asset_warehouse['asset']['unitSale']->operator_value;
            } else {
                $item['qte_sale'] = $asset_warehouse->qte / $asset_warehouse['asset']['unitSale']->operator_value;
                $price = $asset_warehouse['asset']->price * $asset_warehouse['asset']['unitSale']->operator_value;
            }

            if ($asset_warehouse['asset']['unitPurchase']->operator == '/') {
                $item['qte_purchase'] = round($asset_warehouse->qte * $asset_warehouse['asset']['unitPurchase']->operator_value, 5);
            } else {
                $item['qte_purchase'] = round($asset_warehouse->qte / $asset_warehouse['asset']['unitPurchase']->operator_value, 5);
            }

            $item['qte'] = $asset_warehouse->qte;
            $item['unitSale'] = $asset_warehouse['asset']['unitSale']->ShortName;
            $item['unitPurchase'] = $asset_warehouse['asset']['unitPurchase']->ShortName;

            if ($asset_warehouse['asset']->TaxNet !== 0.0) {
                //Exclusive
                if ($asset_warehouse['asset']->tax_method == '1') {
                    $tax_price = $price * $asset_warehouse['asset']->TaxNet / 100;
                    $item['Net_price'] = $price + $tax_price;
                    // Inxclusive
                } else {
                    $item['Net_price'] = $price;
                }
            } else {
                $item['Net_price'] = $price;
            }

            $data[] = $item;
        }

        return response()->json($data);
    }

    //------------ Get asset By ID -----------------\

    public function show($id)
    {

        $Asset_data = Item::with('unit')
            ->where('id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        $data = [];
        $item['id'] = $Asset_data['id'];
        $item['ar_name'] = $Asset_data['ar_name'];
        $item['en_name'] = $Asset_data['en_name'];
 
 
        $data[] = $item;

        return response()->json($data[0]);
    }



 

    //---------------- Show Form Create Asset ---------------\

    public function create(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'create', Asset::class);

        $Locations = Location::where('deleted_at', null)->get(['id', 'ar_name']);


        $categories = Category::where('deleted_at', null)->get(['id', 'name']);
        $groups = Group::where('deleted_at', null)->get(['id', 'ar_name']);

        $clients = Client::where('deleted_at', null)->get(['id', 'name' , 'email']);
        $room   = Room::where('deleted_at', '=', null)->get([ 'id', 'ar_name' ]);
        
        return response()->json([
            'rooms' => $room,
            'locations' => $Locations,
            'categories' => $categories,
            'groups' =>  $groups,
            'clients' => $clients,
        ]);

    }

 

    //---------------- Show Form Edit Asset ---------------\

    public function edit(Request $request, $id)
    {
    
        // $this->authorizeForUser($request->user('api'), 'update', Asset::class);
        $Asset = Item::with('room.floor.location')->where('deleted_at', '=', null)->findOrFail($id);
        $item['id'] = $Asset->id;
        $item['purchase_date'] = $Asset->purchase_date;
        $item['ar_name'] = $Asset->ar_name;
        $item['location_id'] = $Asset->room->floor->location->id;
        $item['client_id'] = $Asset->client_id;
        $item['category_id'] = $Asset->category_id;
        $item['major_id'] = $Asset->major_id;
        $item['minor_id'] = $Asset->minor_id;
        $item['detaild_id'] = $Asset->detaild_id;
        $item['orical_number'] = $Asset->orical_number;
        $item['room_number'] = $Asset->room_number;
        $item['room_id'] = $Asset->room_id;
        $item['floor_id'] = $Asset->room->floor->id;
        $item['group_id'] = $Asset->group_id;
        $item['description'] = $Asset->description;
        $item['status'] = $Asset->status;

 
 
        $item['images'] = [];
        if ($Asset->image != '' && $Asset->image != 'no-image.png') {
            foreach (explode(',', $Asset->image) as $img) {
                $path = public_path() . '/images/items/' . $img;
                if (file_exists($path)) {
                    $itemImg['name'] = $img;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $itemImg['path'] = 'data:image/' . $type . ';base64,' . base64_encode($data);

                    $item['images'][] = $itemImg;
                }
            }
        } else {
            $item['images'] = [];
        }
 
        $data = $item;




        $Locations = Location::where('deleted_at', null)->get(['id', 'ar_name']);
        $categories = Category::where('deleted_at', null)->get(['id', 'name']);
        $groups = Group::where('deleted_at', null)->get(['id', 'ar_name']);
        $clients = Client::where('deleted_at', null)->get(['id', 'name' , 'email']);
        $rooms = Room::where('deleted_at', null)->get(['id', 'ar_name']);
        $floors = Build::where('deleted_at', null)->get(['id', 'ar_name']);

 
        return response()->json([
            'asset' => $data,
            'rooms' => $rooms ,
            'locations' => $Locations,
            'categories' => $categories,
            'groups' =>  $groups,
            'clients' => $clients,
            'floors' => $floors,
           
        ]);

    }

   
    // import Assets
    public function import_assets(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $file_upload = $request->file('assets');
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


                 

                    //-- Create New Asset
                    foreach ($data as $key => $value) {
    
 
                        $Asset = new Asset;
                        $Asset->ar_name = $value['ar_name'] ;
                        $Asset->en_name = $value['en_name'] ;
 
                        $Asset->image = 'no-image.png';
                        $Asset->save();

                
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


    // Generate_random_code
    public function generate_random_code($value_code)
    {
        if($value_code == ''){
            $gen_code = substr(number_format(time() * mt_rand(), 0, '', ''), 0, 8);
            $this->check_code_exist($gen_code);
        }else{
            $this->check_code_exist($value_code);
        }
    }



    public function GetAllAssets(request $request)
    {
  
  
        $assets = Asset::where('deleted_at', '=', null)->get();

        return response()->json([
            'assets' => $assets ,
 
        ]);

    
    }

   }