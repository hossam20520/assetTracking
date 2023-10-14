<?php
namespace App\Http\Controllers;

use App\Models\Group;
use App\utils\helpers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class GroupsController extends Controller
{

    //------------ GET ALL Groups -----------\

    public function index(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'view', Group::class);
        // How many items do you want to display.
        $perPage = $request->limit;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;
        $helpers = new helpers();

        $groups = Group::where('deleted_at', '=', null)->where(function ($query) use ($request) {
                return $query->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('ar_name', 'LIKE', "%{$request->search}%");
                });
            });
        $totalRows = $groups->count();
        $groups = $groups->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'groups' => $groups,
            'totalRows' => $totalRows,
        ]);

    }

    //---------------- STORE NEW Group -------------\

    public function store(Request $request)
    {
        // $this->authorizeForUser($request->user('api'), 'create', Group::class);

        request()->validate([
            'ar_name' => 'required',
        ]);

        \DB::transaction(function () use ($request) {

     

            $Group = new Group;

 
            $Group->ar_name = $request['ar_name'];
 
            $Group->save();

        }, 10);

        return response()->json(['success' => true]);

    }

     //------------ function show -----------\

     public function show($id){
        //
    
    }

     //---------------- UPDATE Group -------------\

     public function update(Request $request, $id)
     {
 
        //  $this->authorizeForUser($request->user('api'), 'update', Group::class);
 
         request()->validate([
             'ar_name' => 'required',
         ]);
         \DB::transaction(function () use ($request, $id) {
             $Group = Group::findOrFail($id);
       
 
   
 
             Group::whereId($id)->update([
                 'ar_name' => $request['ar_name'],
 
             ]);
 
         }, 10);
 
         return response()->json(['success' => true]);
     }

    //------------ Delete Group -----------\

    public function destroy(Request $request, $id)
    {
        // $this->authorizeForUser($request->user('api'), 'delete', Group::class);

        Group::whereId($id)->update([
            'deleted_at' => Carbon::now(),
        ]);
        return response()->json(['success' => true]);
    }

    //-------------- Delete by selection  ---------------\

    public function delete_by_selection(Request $request)
    {

        $this->authorizeForUser($request->user('api'), 'delete', Group::class);

        $selectedIds = $request->selectedIds;
        foreach ($selectedIds as $group_id) {
            Group::whereId($group_id)->update([
                'deleted_at' => Carbon::now(),
            ]);
        }
        return response()->json(['success' => true]);

    }

}

