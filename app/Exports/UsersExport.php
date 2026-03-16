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
    private $rowNumber = 0;

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
        return 'A1';
    }

    public function headings(): array
    {
        return [
            'NO',
            'NIK',
            'KTA',
            'NAMA',
            'JOINT DATE',
            'KTP',
            'ALAMAT',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
            'BAGIAN',
            'AGAMA',
            'EMAIL',
            'PENDIDIKAN',
            'NO TELEPON',
            'BARCODE',
            'PIN',
            'PASSWORD'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5, // NO
            'B' => 20, // NIK
            'C' => 20, // KTA
            'D' => 35, // NAMA
            'E' => 20, // JOINT DATE
            'F' => 20, // KTP
            'G' => 80, // ALAMAT
            'H' => 20, // TEMPAT LAHIR
            'I' => 20, // TANGGAL LAHIR
            'J' => 20, // JENIS KELAMIN
            'K' => 25, // BAGIAN
            'L' => 15, // AGAMA
            'M' => 30, // EMAIL
            'N' => 15, // PENDIDIKAN
            'O' => 20, // NO TELEPON
            'P' => 20, // BARCODE
            'Q' => 10, // PIN
            'R' => 15, // PASSWORD
        ];
    }

    public function map($user): array
    {
        $this->rowNumber++;
        \Carbon\Carbon::setLocale('id');
        return [
            $this->rowNumber,
            (string)$user->nik_karyawan,
            (string)$user->kta_number,
            $user->name,
            $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-',
            (string)$user->nik_ktp,
            $user->address,
            $user->birth_place,
            $user->birth_date ?\Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') : '-',
            $user->gender == 'male' ? 'Laki-Laki' : 'Perempuan',
            $user->department,
            $user->religion,
            $user->email,
            $user->education,
            (string)$user->phone,
            (string)$user->barcode_number,
            '', // PIN
            '' // Password
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $range = 'A1:' . $highestColumn . $highestRow;

            // Style Table Header (Baris 1)
            $headerRange = 'A1:R1';
            $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

            // Apply Borders to All Data
            $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

            // Reset Row Height to normal
            $sheet->getRowDimension(1)->setRowHeight(-1);

            // Align semua data ke kiri
            if ($highestRow > 1) {
                $sheet->getStyle('A2:R' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Kolom NO (A) rata tengah
                $sheet->getStyle('A2:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Format kolom numerik sebagai TEXT
                // B: NIK, C: KTA, F: KTP, O: NO TELEPON, P: BARCODE
                $sheet->getStyle('B2:C' . $highestRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('F2:F' . $highestRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('O2:P' . $highestRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            }
        },
        ];
    }
}
