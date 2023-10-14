<?php

namespace App\Exports;

use App\Models\Item;
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

                $item['major_id'] = $client->major_id;
                $item['major_name'] =   $major->name;
                $item['minor_id'] = $client->minor_id;
                $item['minor_name'] =   $minor->name;
                $item['detaild_id'] = $client->detaild_id;
                $item['detaild'] =   $detaild->name;
                $item['room_id'] = $client->room_id;
                $item['room_number'] = $client->room_number;
                $item['orical_number'] = $client->orical_number;
                $item['ar_name'] = $client->ar_name;
           
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

    public function headings(): array
    {

   

        return [
            'room_join_item_uuid',
            'item_uuid',
            'minor_id',
            'minor_name',
            'detaild_id',
            'detaild',
            'room_id',
            'room_number',
            'orical_number',
            'ar_name',
        ];



    }
}
