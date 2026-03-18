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
        return collect([]);
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
            'A' => 5,  // NO
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
            'R' => 25, // PASSWORD
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Style Header (Baris 1)
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

                // Set Header Height Normal
                $sheet->getRowDimension(1)->setRowHeight(-1);

                // Format kolom numerik sebagai TEXT agar angka panjang tidak berubah
                // B: NIK, C: KTA, F: KTP, O: NO TELEPON, P: BARCODE, Q: PIN
                $sheet->getStyle('B2:C1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('F2:F1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('O2:Q1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Format TANGGAL LAHIR (I) dan JOINT DATE (E) sebagai TEXT agar tidak diubah Excel
                $sheet->getStyle('E2:E1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('I2:I1000')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Rata kiri untuk semua data
                $sheet->getStyle('A2:R1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Kolom NO (A) rata tengah
                $sheet->getStyle('A2:A1000')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Validasi NIK (Kolom B - Wajib Angka)
                $nikValidation = $this->createNumericOnlyValidation('B', 'NIK harus berupa angka');
                $sheet->setDataValidation('B2:B1000', $nikValidation);

                // Validasi KTA (Kolom C - Wajib Angka)
                $ktaValidation = $this->createNumericOnlyValidation('C', 'KTA harus berupa angka');
                $sheet->setDataValidation('C2:C1000', $ktaValidation);

                // Validasi KTP (Kolom F - Angka)
                $ktpValidation = $this->createNumericOnlyValidation('F', 'KTP harus berupa angka');
                $sheet->setDataValidation('F2:F1000', $ktpValidation);

                // Validasi PIN (Kolom Q - Harus 6 Karakter & Angka)
                $pinValidation = $this->createCustomLengthValidation('Q', 6, 'PIN harus 6 digit angka', true);
                $sheet->setDataValidation('Q2:Q1000', $pinValidation);

                // Gender Dropdown (Kolom J - JENIS KELAMIN)
                $genders = '"Laki-Laki,Perempuan"';
                $sheet->setDataValidation('J2:J1000', $this->createValidation($genders));

                // Religion Dropdown (Kolom L - AGAMA)
                $religions = '"Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu,Lainnya"';
                $sheet->setDataValidation('L2:L1000', $this->createValidation($religions));

                // Education Dropdown (Kolom N - PENDIDIKAN)
                $educations = '"SD,SMP,SMA/SMK,D3,S1,S2,S3"';
                $sheet->setDataValidation('N2:N1000', $this->createValidation($educations));
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
