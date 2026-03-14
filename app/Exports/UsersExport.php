<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths, WithCustomStartCell, WithCustomValueBinder
{
    /**
     * Force long numeric strings to be treated as Strings in Excel
     */
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value) && strlen((string)$value) > 10) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role', '!=', 'admin')->latest()->get();
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK KTP',
            'NIK Karyawan',
            'Nomor KTA',
            'Nomor Barcode',
            'Email',
            'Departemen',
            'No. Telp (WA)',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Pendidikan',
            'Alamat',
            'Tanggal Daftar'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Nama
            'B' => 20, // NIK KTP
            'C' => 20, // NIK Karyawan
            'D' => 20, // Nomor KTA
            'E' => 20, // Nomor Barcode
            'F' => 25, // Email
            'G' => 20, // Departemen
            'H' => 20, // No. Telp (WA)
            'I' => 20, // Tempat Lahir
            'J' => 15, // Tanggal Lahir
            'K' => 15, // Jenis Kelamin
            'L' => 15, // Agama
            'M' => 15, // Pendidikan
            'N' => 30, // Alamat
            'O' => 20, // Tanggal Daftar
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            (string)$user->nik_ktp,
            (string)$user->nik_karyawan,
            (string)$user->kta_number,
            (string)$user->barcode_number,
            $user->email,
            $user->department,
            (string)$user->phone,
            $user->birth_place,
            $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '-',
            $user->gender == 'male' ? 'Laki-Laki' : 'Perempuan',
            $user->religion,
            $user->education,
            $user->address,
            $user->created_at->format('d/m/Y H:i')
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set Info di baris 1 dan 2
                $sheet->setCellValue('A1', 'DATA ANGGOTA - PION APP');
                $sheet->setCellValue('A2', 'Diekspor pada: ' . now()->format('d/m/Y H:i:s'));
                
                $sheet->mergeCells('A1:O1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                
                // Style Table Header (Baris 3 karena startCell A3)
                $headerRange = 'A3:O3';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'AA2224'], // Brand Red
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Set Header Height
                $sheet->getRowDimension(3)->setRowHeight(30);
                
                // Format Kolom NIK, KTA, Barcode, Phone sebagai TEXT agar 0 tidak hilang & no scientific notation
                // B: NIK KTP, C: NIK Karyawan, D: KTA, E: Barcode, H: No. Telp (WA)
                $sheet->getStyle('B4:E5000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('H4:H5000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Align Tanggal Lahir (Kolom J) to Left
                $sheet->getStyle('J4:J5000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
