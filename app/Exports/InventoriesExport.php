<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Item;
use App\Models\Inventorie;
use App\Models\Session;
// sessions
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

// Don’t Remove	room_join_item_uuid	item_uuid	item_name	major_uuid	major_name	minor_uuid	minor_name	detaild_uuid	detaild_name	room_floar_join_room	room_number	orical_number	room_uuid	room_name	room_floar_join_location_uuid	room_floar	room_floar_uuid	location_name	location_uuid


class InventoriesExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{

    public function __construct($date) {
        $this->date = $date;
      
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    function array(): array
    {
      
        $Assets = Item::with('Major' , 'Minor' , 'detailed' , 'room')->where('deleted_at' , '=' , null)->get();
        foreach ( $Assets as   $asset ) {
            $item['location_uuid'] =  $asset->room->floor->location->uuid;
            $item['location_name'] = $asset->ar_name;
            $item['room_floar_uuid'] = $asset->room->floor->uuid;
            $item['room_floar'] = $asset->room->floor->ar_name;
            $item['room_floar_join_location_uuid'] =  $asset->room->floor->location->uuid;
            $item['room_name'] =  $asset->room->ar_name;
            $item['room_uuid'] = $asset->room->uuid;
            $item['orical_number'] =  $asset->orical_number;
            $item['room_number'] = $asset->room->room_number;
            $item['room_floar_join_room'] = $asset->room->floor->uuid;
            $item['detaild_name'] = $asset->detailed->name;
            $item['detaild_uuid'] = $asset->detailed->uuid;
            $item['minor_name'] =  $asset->Minor->name;
            $item['minor_uuid'] =  $asset->Minor->uuid;
            $item['major_name'] =  $asset->Major->name;
            $item['major_uuid'] =  $asset->Major->uuid;
            $item['item_name'] =  $asset->ar_name;
            $item['item_uuid'] =  $asset->uuid;
            $item['room_join_item_uuid'] =  $asset->room->uuid;
            $item['status'] = $this->GetStatusBYdate($this->date , $asset->id);
            $item['start_date'] =  $this->getStartDate( $this->date , $asset->id );
            $item['end_date'] = $this->getEndDate(  $this->date , $asset->id) ;
            $data[] = $item;
        }
 

      

        return $data;
    }



    public function GetStatusBYdate($date , $item){

        $inventories =  Inventorie::with('sessions')->where('deleted_at' , '=' , null)->where('start_session_date' , $date)->first();
      
        $session =   Session::where('deleted_at' , '=' , null)->where('item_id'  , $item )->first();

        if(!$session ){
          return "NOt_inventoried";
        }else{
            return  $session->item_status;  
        }

 
    }


   
    public function getStartDate($date , $item_id  ){

        $inventories =  Inventorie::with('sessions') ->where('deleted_at', '=', null)
        ->where('start_session_date', $date)
        ->first();

        $sessions = $inventories->sessions->where('item_id', $item_id)->first();

        if(!$sessions ){
          return "no_date";
        }else{
          

            return  $inventories->start_session_date;
        }

 
    }
    
    public function getEndDate($date , $item_id  ){

  
        $inventories =  Inventorie::with('sessions') ->where('deleted_at', '=', null)
        ->where('start_session_date', $date)
        ->first();

        $sessions = $inventories->sessions->where('item_id', $item_id)->first();

        if(!$sessions ){
          return "no_date";
        }else{
          

            return  $inventories->end_session_date;
        }

 
    }



    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:H1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ],

                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ];

            },
        ];

    }
 
    
  
 
 
 
    public function headings(): array
    {
        return [
            'location_uuid',
            'location_name',
            'room_floar_uuid',
            'room_floar',
            'room_floar_join_location_uuid',
            'room_name',
            'room_uuid',
            'orical_number',
            'room_number',
            'room_floar_join_room',
            'detaild_name',
            'detaild_uuid',
            'minor_name',
            'minor_uuid',
            'major_name',
            'major_uuid',
            'item_name',
            'item_uuid',
            'room_join_item_uuid',
            'status',
            'start_date',
            'end_date',
        ];
    }


}
