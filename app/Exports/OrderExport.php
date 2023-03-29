<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithStyles;

class OrderExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithDefaultStyles, WithStyles
{
    // protected $data;

    // public function __construct($data) {
    //     $this->data = $data;
    // }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection($data)
    {
        return $data;
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Vehicle',
            'Date Start',
            'Date End'
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        // Or return the styles array
        return [
            'alignment' => [
                'horizontal'   => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => Color::COLOR_BLACK]
                ],
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ]
                ],
        ];
    }
}
