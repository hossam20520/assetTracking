<?php
namespace App\Http\Controllers;

use App\Models\Location;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class LocationsController extends Controller
{

    //------------ GET ALL Locations -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Location::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $locations = Location::with('location')->where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $locations->count();
        $locations = $locations->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();


        $Locations = Location::where('deleted_at', null)->get(['id', 'ar_name']);

        return response()->json([
            'locations' => $locations,
            'totalRows' => $totalRows,
            'Locations' =>  $Locations,
        ]);

    }

    //---------------- STORE NEW Location -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Location::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {
 
             $locaitons = Location::max('uuid');
            $Location = new Location;
            if($request['uuid'] ==  ""){
                $Location->uuid =  intval($locaitons) + 1;  ; 
            }else{
                $Location->uuid = $request['uuid'];
            }
          
          
            $Location->ar_name = $request['ar_name'];
            $Location->parent_id  = $request['parent_id'];
            $Location->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Location -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Location::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Location = Location::findOrFail($id);
     

             Location::whereId($id)->update([
                  'uuid' => $request['uuid'],
                 'ar_name' => $request['ar_name'],
                 'parent_id' => $request['parent_id'],
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Location -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Location::class);

        Location::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        // $this->authorizeForUser($request->user('api'), 'delete', Location::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $location_id) {
            Location::whereId($location_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

