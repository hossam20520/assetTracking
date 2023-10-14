<?php
namespace App\Http\Controllers;

use App\Models\Inventore;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class InventoresController extends Controller
{

    //------------ GET ALL Inventores -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Inventore::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();


        
        $inventores = Inventore::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $inventores->count();
        $inventores = $inventores->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();
             $data = array();
            foreach ($inventores as   $va) {

                 $item['start_session_date'] =  $va->start_session_date;
                 $item['end_session_date'] =  $va->end_session_date;
                //  $item['session_status'] =  $va->session_status;
                //  $item['location'] =  $va->location;
                //  $item['room'] =  $va->room;
                //  $item['floor'] =  $va->floor;
                 $data[] = $item;
            }

        return response()->json([
            'inventores' => $data,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Inventore -------------\

    public function store(Request $request)
    {
        $this->authorizeForUser($request->user('api'), 'create', Inventore::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(200, 200);
                $image_resize->save(public_path('/images/inventores/' . $filename));

            } else {
                $filename = 'no-image.png';
            }

            $Inventore = new Inventore;

            $Inventore->en_name = $request['en_name'];
            $Inventore->ar_name = $request['ar_name'];
            $Inventore->image = $filename;
            $Inventore->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Inventore -------------\

     public function update(Request $request, $id)
     {
 
         $this->authorizeForUser($request->user('api'), 'update', Inventore::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Inventore = Inventore::findOrFail($id);
             $currentImage = $Inventore->image;
 
             // dd($request->image);
             if ($currentImage && $request->image != $currentImage) {
                 $image = $request->file('image');
                 $path = public_path() . '/images/inventores';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/inventores/' . $filename));
 
                 $InventoreImage = $path . '/' . $currentImage;
                 if (file_exists($InventoreImage)) {
                     if ($currentImage != 'no-image.png') {
                         @unlink($InventoreImage);
                     }
                 }
             } else if (!$currentImage && $request->image !='null'){
                 $image = $request->file('image');
                 $path = public_path() . '/images/inventores';
                 $filename = rand(11111111, 99999999) . $image->getClientOriginalName();
 
                 $image_resize = Image::make($image->getRealPath());
                 $image_resize->resize(200, 200);
                 $image_resize->save(public_path('/images/inventores/' . $filename));
             }
 
             else {
                 $filename = $currentImage?$currentImage:'no-image.png';
             }
 
             Inventore::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
                 'description' => $request['en_name'],
                 'image' => $filename,
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Inventore -----------\

    public function destroy(Request $request, $id)
    {
        $this->authorizeForUser($request->user('api'), 'delete', Inventore::class);

        Inventore::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'delete', Inventore::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $inventore_id) {
            Inventore::whereId($inventore_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

