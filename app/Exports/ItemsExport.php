<?php

namespace App\Exports;

use App\Models\Item;
use App\Models\Room;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Category;


class ItemsExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function array(): array
    {
        $clients = Item::where('deleted_at', '=', null)->orderBy('id', 'DESC')->get();
        if ($clients->isNotEmpty()) {

            foreach ($clients as $client) {
                // detaild_id
                $major   = Category::where('deleted_at', '=', null)->where('id' , $client->major_id )->first();
                $minor   = Category::where('deleted_at', '=', null)->where('id' , $client->minor_id )->first();
                $detaild = Category::where('deleted_at', '=', null)->where('id' , $client->detaild_id )->first();
                


                $item['room_name'] =   $this->getRoomInfo( $client->room_id); //$client->major_id;
                $item['item_name'] =   $client->ar_name;
                $item['major_name'] =  $detaild->name;
                $item['minor_name'] =    $detaild->name;
                $item['detaild_name'] =  $detaild->name;
                $item['uuid'] =  $client->uuid;
                $item['oracle_number'] = $client->orical_number;
      

                // 'room_name',
                // 'item_name',
                // 'major_name',
                // 'minor_name',
                // 'detaild_name',
                // 'uuid',
                // 'oracle_number',

                // $item['adresse'] = substr($client->adresse, 0, 20);

                $data[] = $item;
            }
        } else {
            $data = [];
        }

        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:E1'; // All headers
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


    public function getRoomInfo($id){
        $room_name = Room::where('deleted_at', '=', null)->where('id' , $id )->first();

        if($room_name){
            return $room_name->ar_name;
        }else{
            return "empty";   
        }
    }

    public function headings(): array
    {

   

        return [
            'room_name',
            'item_name',
            'major_name',
            'minor_name',
            'detaild_name',
            'uuid',
            'oracle_number',
         
        ];

        // 'room_name',
        // 'item_uuid',
        // 'minor_id',
        // 'minor_name',
        // 'detaild_id',
        // 'detaild',
        // 'room_id',
        // 'room_number',
        // 'orical_number',
        // 'ar_name',

    }
}
