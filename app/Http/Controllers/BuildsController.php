<?php
namespace App\Http\Controllers;

use App\Models\Build;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class BuildsController extends Controller
{

    //------------ GET ALL Builds -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Build::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();
        $id = $request->id;

        $builds = Build::where('deleted_at', '=', null)->where('location_id' ,  $id)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%")
                        ->orWhere('en_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $builds->count();
        $builds = $builds->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'builds' => $builds,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Build -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Build::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

            $build = Build::max('uuid');
         
     

            $Build = new Build;
            $Build->location_id   =    $request['location_id'];
            if($request['uuid'] ==  ""){
                $Build->uuid =  intval($build) + 1;  
             
            }else{
                $Build->uuid = $request['uuid'];
            }
            $Build->ar_name       =    $request['ar_name'];
     
            $Build->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Build -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Build::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Build = Build::findOrFail($id);

             Build::whereId($id)->update([
                'uuid' => $request['uuid'],
                 'ar_name' => $request['ar_name'],
                 'location_id' => $request['location_id'],
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Build -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Build::class);

        Build::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'delete', Build::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $build_id) {
            Build::whereId($build_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

