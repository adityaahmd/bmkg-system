<?php
// app/Exports/ReportExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;
    protected $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        switch ($this->type) {
            case 'revenue':
                return ['Tanggal', 'Total Revenue'];
            case 'sales':
                return ['Produk', 'Kategori', 'Jumlah Terjual'];
            case 'users':
                return ['ID', 'Nama', 'Email', 'Tanggal Daftar'];
            default:
                return ['Data'];
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}