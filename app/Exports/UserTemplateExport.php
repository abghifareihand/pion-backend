<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UserTemplateExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithEvents, WithColumnWidths, WithCustomValueBinder
{
    /**
     * Force long numeric strings to be treated as Strings in Excel
     */
    public function bindValue(Cell $cell, $value)
    {
        // If the value is a string of numbers longer than 10 digits, force it as String type
        if (is_numeric($value) && strlen((string)$value) > 10) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // Return default behavior for other values
        return parent::bindValue($cell, $value);
    }

    /**
     * Return a sample data row
     */
    public function collection()
    {
        return collect([
            [
                '2024001',                       // NIK
                '12345001',                      // KTA
                'John Doe',                      // NAMA
                '1234567890123456',              // KTP
                'Jl. Mawar No. 123, Jakarta',   // ALAMAT
                'Jakarta',                       // TEMPAT LAHIR
                '01-01-1990',                    // TANGGAL LAHIR
                'Laki-Laki',                     // JENIS KELAMIN
                'IT Department',                 // BAGIAN
                'Islam',                         // AGAMA
                'john@example.com',              // EMAIL
                'S1',                            // PENDIDIKAN
                '081234567890',                  // NO TELEPON
                '123456789',                     // BARCODE
                '123456',                        // PIN (6 Digit)
                'password123'                    // PASSWORD
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'NIK',
            'KTA',
            'NAMA',
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
            'A' => 20, // NIK
            'B' => 20, // KTA
            'C' => 35, // NAMA
            'D' => 20, // KTP
            'E' => 80, // ALAMAT
            'F' => 20, // TEMPAT LAHIR
            'G' => 20, // TANGGAL LAHIR
            'H' => 20, // JENIS KELAMIN
            'I' => 25, // BAGIAN
            'J' => 15, // AGAMA
            'K' => 30, // EMAIL
            'L' => 15, // PENDIDIKAN
            'M' => 20, // NO TELEPON
            'N' => 20, // BARCODE
            'O' => 10, // PIN
            'P' => 15, // PASSWORD
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Style Header (Baris 1)
                $headerRange = 'A1:P1';
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

                // Set Header Height Normal
                $sheet->getRowDimension(1)->setRowHeight(-1);

                // Format kolom numerik sebagai TEXT agar angka panjang tidak berubah
                // A: NIK, B: KTA, D: KTP, M: NO TELEPON, N: BARCODE, O: PIN
                $sheet->getStyle('A2:B1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('D2:D1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('M2:O1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Format TANGGAL LAHIR (G) sebagai TEXT agar tidak diubah Excel
                $sheet->getStyle('G2:G1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Rata kiri untuk semua data
                $sheet->getStyle('A2:P1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Validasi NIK (Kolom A - Wajib Angka)
                $nikValidation = $this->createNumericOnlyValidation('A', 'NIK harus berupa angka');
                $sheet->setDataValidation('A2:A1000', $nikValidation);

                // Validasi KTA (Kolom B - Wajib Angka)
                $ktaValidation = $this->createNumericOnlyValidation('B', 'KTA harus berupa angka');
                $sheet->setDataValidation('B2:B1000', $ktaValidation);

                // Validasi KTP (Kolom D - Wajib Angka)
                $ktpValidation = $this->createNumericOnlyValidation('D', 'KTP harus berupa angka');
                $sheet->setDataValidation('D2:D1000', $ktpValidation);

                // Validasi PIN (Kolom O - Harus 6 Karakter & Angka)
                $pinValidation = $this->createCustomLengthValidation('O', 6, 'PIN harus 6 digit angka', true);
                $sheet->setDataValidation('O2:O1000', $pinValidation);

                // Gender Dropdown (Kolom H - JENIS KELAMIN)
                $genders = '"Laki-Laki,Perempuan"';
                $sheet->setDataValidation('H2:H1000', $this->createValidation($genders));

                // Religion Dropdown (Kolom J - AGAMA)
                $religions = '"Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu,Lainnya"';
                $sheet->setDataValidation('J2:J1000', $this->createValidation($religions));

                // Education Dropdown (Kolom L - PENDIDIKAN)
                $educations = '"SD,SMP,SMA/SMK,D3,S1,S2,S3"';
                $sheet->setDataValidation('L2:L1000', $this->createValidation($educations));
            },
        ];
    }

    private function createCustomLengthValidation($column, $length, $message, $mustBeNumeric = false)
    {
        $validation = new DataValidation();
        $validation->setType(DataValidation::TYPE_CUSTOM);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setErrorTitle('Kesalahan Input');
        $validation->setError($message);
        
        $formula = 'LEN(' . $column . '2)=' . $length;
        if ($mustBeNumeric) {
            $formula = 'AND(ISNUMBER(VALUE(' . $column . '2)), ' . $formula . ')';
        }
        
        $validation->setFormula1('=' . $formula);
        return $validation;
    }

    private function createNumericOnlyValidation($column, $message)
    {
        $validation = new DataValidation();
        $validation->setType(DataValidation::TYPE_CUSTOM);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setErrorTitle('Kesalahan Input');
        $validation->setError($message);
        $validation->setFormula1('=ISNUMBER(VALUE(' . $column . '2))');
        return $validation;
    }

    private function createValidation($options)
    {
        $validation = new DataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setErrorTitle('Input Error');
        $validation->setError('Value is not in list.');
        $validation->setFormula1($options);

        return $validation;
    }
}
