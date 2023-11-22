<?php
namespace App\Http\Controllers;

use App\Models\Transfear;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class TransfearsController extends Controller
{

    //------------ GET ALL Transfears -----------\

    public function index(Request $request)
    {
        $this->authorizeForUser($request->user('api'), 'view', Transfear::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $transfears = Transfear::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $transfears->count();
        $transfears = $transfears->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'transfears' => $transfears,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Transfear -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Transfear::class);

        // request()->validate([
        //     'ar_name' => 'required',
        // ]);

        \DB::transaction(function () use ($request) {

         

            $Transfear = new Transfear;

            $Transfear->en_name = $request['item_id'];
            $Transfear->ar_name = $request['ar_name'];
            $Transfear->ar_name = $request['ar_name'];
            $Transfear->ar_name = $request['ar_name'];
            $Transfear->image = $filename;
            $Transfear->save();
            // 'item_id', 'old_room_id',  
            // 'old_location_id', 
            // 'old_floor_id', 
            // 'user_id', 
            // 'inventorie', 
            // 'date', 
        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Transfear -------------\

     public function update(Request $request, $id)
     {
 
         $this->authorizeForUser($request->user('api'), 'update', Transfear::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Transfear = Transfear::findOrFail($id);
             $currentImage = $Transfear->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/transfears';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/transfears/' . $filename));
 
                 $TransfearImage = $path . '/' . $currentImage;
                 if (file_exists($TransfearImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($TransfearImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/transfears';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/transfears/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 
             Transfear::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'description' => $request['en_name'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Transfear -----------\

    public function destroy(Request $request, $id)
    {
        $this->authorizeForUser($request->user('api'), 'delete', Transfear::class);

        Transfear::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'delete', Transfear::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $transfear_id) {
            Transfear::whereId($transfear_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

