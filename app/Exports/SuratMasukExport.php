<?php

namespace App\Exports;

use App\Models\SuratMasuk;
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

class SuratMasukExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
                'Tanggal',
                'Nomor Surat',
                'Perihal',
                'Asal Surat',
                'Tujuan Surat',
                'Pinjam',
                'Kembali',
                'Keterangan',
            ]
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SuratMasuk::whereBetween('tanggal', [$this->tanggal_awal, $this->tanggal_akhir])->get();
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $this->awal++;
        return [
            $this->rowNumber,
            $row->tanggal,
            $row->no_surat,
            $row->perihal,
            $row->pengirim_surat,
            $row->tujuan_surat,
            $row->peminjaman,
            $row->pengembalian,
            strip_tags($row->keterangan),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I2');
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(50);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:I'.$this->awal)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:I'.$this->awal)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:I2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:I3')->getFont()->setBold(true);
        $sheet->getStyle('A1:I3')->getFont()->setName('Times New Roman');
        $sheet->getStyle('A1:I3')->getFont()->setSize(12);
        $sheet->getStyle('A3:I3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $sheet->getStyle('A3:I3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('6699CC');
        $sheet->getStyle('A3:I'.$this->awal)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}