<?php

namespace App\Exports;

use App\Models\GuestBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class GuestExportNew implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    public $tanggal_awal;
    public $tanggal_akhir;
    public $judul;
    private $rowNumber = 0;
    public $awal = 3;

    public function __construct($judul, $tanggal_awal, $tanggal_akhir)
    {
        $this->judul = $judul;
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function headings() : array
    {
        return [
            [$this->judul],
            [],
            [
                'NO',
                'Nama',
                'NIM/NIP/NIK/NISN',
                'Asal Instansi',
                'Nomor HP',
                'Email',
                'Keperluan',
                'Waktu'
            ]
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GuestBook::with('guest')->whereBetween('created_at', [$this->tanggal_awal, $this->tanggal_akhir])->get();
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $this->awal++;
        return [
            $this->rowNumber,
            $row->guest->name,
            $row->guest->identity_number,
            $row->instansi,
            $row->guest->phone,
            $row->guest->email,
            $row->description,
            Carbon::parse($row->created_at)->format('d-m-Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:H2');
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(47);
        $sheet->getColumnDimension('C')->setWidth(19);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(28);
        $sheet->getColumnDimension('G')->setWidth(28);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:H3')->getFont()->setBold(true);
        $sheet->getStyle('A1:H3')->getFont()->setName('Times New Roman');
        $sheet->getStyle('A1:H3')->getFont()->setSize(12);
        $sheet->getStyle('A3:H3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $sheet->getStyle('A3:H3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('6699CC');
        $sheet->getStyle('A3:H'.$this->awal)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
