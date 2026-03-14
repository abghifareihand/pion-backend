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
                'John Doe',
                '1234567890123456', // NIK KTP
                '2024001',           // NIK Karyawan
                '12345001',          // Nomor KTA
                '123456789',         // Nomor Barcode
                'john@example.com',
                'IT Department',
                '081234567890',      // No. Telp (WA)
                'Jakarta',
                '01/01/1990',        // Tanggal Lahir
                'Laki-Laki',         // Jenis Kelamin
                'Islam',             // Agama
                'S1',                // Pendidikan
                'Jl. Mawar No. 123, Jakarta',
                '123456',            // PIN (6 Digit)
                'password123'        // Password
            ]
        ]);
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
            'PIN (6 Digit)',
            'Password'
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
            'J' => 20, // Tanggal Lahir
            'K' => 20, // Jenis Kelamin
            'L' => 15, // Agama
            'M' => 15, // Pendidikan
            'N' => 30, // Alamat
            'O' => 15, // PIN (6 Digit)
            'P' => 15, // Password
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
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Format Kolom NIK, KTA, Barcode, Phone sebagai TEXT agar 0 tidak hilang
                // B: NIK KTP, C: NIK Karyawan, D: KTA, E: Barcode, H: No. Telp (WA), O: PIN
                $sheet->getStyle('B2:E1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('H2:H1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('O2:O1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Align Tanggal Lahir (Kolom J) to Left
                $sheet->getStyle('J2:J1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Validasi PIN (Kolom O - Harus 6 Karakter & Angka)
                $pinValidation = $this->createCustomLengthValidation('O', 6, 'PIN harus 6 digit angka', true);
                $sheet->setDataValidation('O2:O1000', $pinValidation);

                // Validasi NIK KTP (Kolom B - Wajib Angka)
                $nikKtpValidation = $this->createNumericOnlyValidation('B', 'NIK KTP harus berupa angka');
                $sheet->setDataValidation('B2:B1000', $nikKtpValidation);

                // Validasi NIK Karyawan (Kolom C - Wajib Angka)
                $nikKarValidation = $this->createNumericOnlyValidation('C', 'NIK Karyawan harus berupa angka');
                $sheet->setDataValidation('C2:C1000', $nikKarValidation);

                // Validasi Nomor KTA (Kolom D - Wajib Angka)
                $ktaValidation = $this->createNumericOnlyValidation('D', 'Nomor KTA harus berupa angka');
                $sheet->setDataValidation('D2:D1000', $ktaValidation);

                // Validasi Nomor Barcode (Kolom E - Wajib Angka)
                $barcodeValidation = $this->createNumericOnlyValidation('E', 'Nomor Barcode harus berupa angka');
                $sheet->setDataValidation('E2:E1000', $barcodeValidation);

                // Gender Dropdown (Kolom K)
                $genders = '"Laki-Laki,Perempuan"';
                $sheet->setDataValidation('K2:K1000', $this->createValidation($genders));

                // Religion Dropdown (Kolom L)
                $religions = '"Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu,Lainnya"';
                $sheet->setDataValidation('L2:L1000', $this->createValidation($religions));

                // Education Dropdown (Kolom M)
                $educations = '"SD,SMP,SMA/SMK,D3,S1,S2,S3"';
                $sheet->setDataValidation('M2:M1000', $this->createValidation($educations));
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
