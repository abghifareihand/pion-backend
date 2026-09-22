<?php

namespace Database\Seeders;

use App\Models\Broadcast;
use App\Models\Financial;
use App\Models\Information;
use App\Models\Learning;
use App\Models\MemberRegistration;
use App\Models\Organization;
use App\Models\Social;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\Union;
use App\Models\User;
use App\Models\Vision;
use App\Models\Vote;
use App\Models\VoteOption;
use App\Models\VoteResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ========================================================
        // 1. SEED USERS (Super Admin, Abghi Fareihan, & Karyawan)
        // ========================================================

        // 1.1 Super Admin
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Super Admin',
                'nik_ktp' => '3273010101900001',
                'nik_karyawan' => 'ADM-001',
                'kta_number' => '20240104',
                'barcode_number' => '899000000001',
                'email' => 'admin@gmail.com',
                'phone' => '081234567890',
                'department' => 'IT System & Administrator',
                'birth_place' => 'Jakarta',
                'birth_date' => '1990-01-01',
                'joint_date' => '2020-01-01',
                'address' => 'Jl. Merdeka No. 1, Jakarta Pusat',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'S1',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'password_hint' => 'admin123',
                'pin' => Hash::make('000000'),
                'pin_hint' => '000000',
            ]
        );

        // 1.2 Data Karyawan Spesifik: Abghi Fareihan (Data Lengkap)
        $abghi = User::updateOrCreate(
            ['username' => 'abghifareihan'],
            [
                'name' => 'Abghi Fareihan',
                'nik_ktp' => '3273011405980002',
                'nik_karyawan' => 'PION-EMP-001',
                'kta_number' => '20240104012001',
                'barcode_number' => '899123456701',
                'email' => 'abghifareihan@gmail.com',
                'phone' => '081223344556',
                'department' => 'Teknologi Informasi & Digital',
                'birth_place' => 'Bandung',
                'birth_date' => '1998-05-14',
                'joint_date' => '2023-02-01',
                'address' => 'Jl. Sukajadi No. 128, Kota Bandung, Jawa Barat',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'S1',
                'role' => 'user',
                'password' => Hash::make('password123'),
                'password_hint' => 'password123',
                'pin' => Hash::make('123456'),
                'pin_hint' => '123456',
            ]
        );

        // 1.3 Data Dummy Karyawan Lainnya (12 Karyawan Berbagai Divisi)
        $karyawanList = [
            [
                'name' => 'Budi Santoso',
                'username' => 'budisantoso',
                'nik_ktp' => '3201121003920003',
                'nik_karyawan' => 'PION-EMP-002',
                'email' => 'budisantoso@example.com',
                'phone' => '081322110001',
                'department' => 'Produksi & Manufaktur',
                'birth_place' => 'Surabaya',
                'birth_date' => '1992-03-10',
                'joint_date' => '2021-06-15',
                'address' => 'Jl. Kebon Jeruk No. 15, Jakarta Barat',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'D3',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'username' => 'sitinurhaliza',
                'nik_ktp' => '3201145207950004',
                'nik_karyawan' => 'PION-EMP-003',
                'email' => 'siti.nurhaliza@example.com',
                'phone' => '081322110002',
                'department' => 'Human Resources & GA',
                'birth_place' => 'Semarang',
                'birth_date' => '1995-07-22',
                'joint_date' => '2022-01-10',
                'address' => 'Jl. Flamboyan No. 8, Tangerang Selatan',
                'gender' => 'female',
                'religion' => 'Islam',
                'education' => 'S1',
            ],
            [
                'name' => 'Dewi Sartika',
                'username' => 'dewisartika',
                'nik_ktp' => '3271036809960005',
                'nik_karyawan' => 'PION-EMP-004',
                'email' => 'dewi.sartika@example.com',
                'phone' => '081322110003',
                'department' => 'Keuangan & Akuntansi',
                'birth_place' => 'Bogor',
                'birth_date' => '1996-09-18',
                'joint_date' => '2022-03-01',
                'address' => 'Jl. Pajajaran No. 45, Bogor',
                'gender' => 'female',
                'religion' => 'Islam',
                'education' => 'S1',
            ],
            [
                'name' => 'Rian Hidayat',
                'username' => 'rianhidayat',
                'nik_ktp' => '3202101504930006',
                'nik_karyawan' => 'PION-EMP-005',
                'email' => 'rian.hidayat@example.com',
                'phone' => '081322110004',
                'department' => 'Maintenance & Utility',
                'birth_place' => 'Sukabumi',
                'birth_date' => '1993-04-15',
                'joint_date' => '2021-08-20',
                'address' => 'Jl. Pelabuhan II No. 70, Sukabumi',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'SMA/SMK',
            ],
            [
                'name' => 'Mega Pratiwi',
                'username' => 'megapratiwi',
                'nik_ktp' => '3204115401970007',
                'nik_karyawan' => 'PION-EMP-006',
                'email' => 'mega.pratiwi@example.com',
                'phone' => '081322110005',
                'department' => 'Quality Control (QC)',
                'birth_place' => 'Bandung',
                'birth_date' => '1997-01-24',
                'joint_date' => '2023-05-10',
                'address' => 'Jl. Buah Batu No. 201, Bandung',
                'gender' => 'female',
                'religion' => 'Islam',
                'education' => 'D3',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'username' => 'ahmadfauzi',
                'nik_ktp' => '3216061111940008',
                'nik_karyawan' => 'PION-EMP-007',
                'email' => 'ahmad.fauzi@example.com',
                'phone' => '081322110006',
                'department' => 'Logistik & Pergudangan',
                'birth_place' => 'Bekasi',
                'birth_date' => '1994-11-11',
                'joint_date' => '2022-09-01',
                'address' => 'Jl. Cut Meutia No. 33, Bekasi',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'SMA/SMK',
            ],
            [
                'name' => 'Nurfadilah',
                'username' => 'nurfadilah',
                'nik_ktp' => '3205084908980009',
                'nik_karyawan' => 'PION-EMP-008',
                'email' => 'nurfadilah@example.com',
                'phone' => '081322110007',
                'department' => 'Produksi & Manufaktur',
                'birth_place' => 'Garut',
                'birth_date' => '1998-08-09',
                'joint_date' => '2023-11-15',
                'address' => 'Jl. Cimanuk No. 89, Garut',
                'gender' => 'female',
                'religion' => 'Islam',
                'education' => 'SMA/SMK',
            ],
            [
                'name' => 'Bayu Wicaksono',
                'username' => 'bayuwicaksono',
                'nik_ktp' => '3374021208910010',
                'nik_karyawan' => 'PION-EMP-009',
                'email' => 'bayu.w@example.com',
                'phone' => '081322110008',
                'department' => 'HSE & Keselamatan Kerja (K3)',
                'birth_place' => 'Semarang',
                'birth_date' => '1991-08-12',
                'joint_date' => '2020-04-01',
                'address' => 'Jl. Pandanaran No. 12, Semarang',
                'gender' => 'male',
                'religion' => 'Kristen',
                'education' => 'S1',
            ],
            [
                'name' => 'Intan Permata',
                'username' => 'intanpermata',
                'nik_ktp' => '3171056506960011',
                'nik_karyawan' => 'PION-EMP-010',
                'email' => 'intan.p@example.com',
                'phone' => '081322110009',
                'department' => 'Hubungan Industrial & Hukum',
                'birth_place' => 'Jakarta Pusat',
                'birth_date' => '1996-06-25',
                'joint_date' => '2021-11-01',
                'address' => 'Jl. Salemba Raya No. 40, Jakarta Pusat',
                'gender' => 'female',
                'religion' => 'Islam',
                'education' => 'S1',
            ],
            [
                'name' => 'Deni Pratama',
                'username' => 'denipratama',
                'nik_ktp' => '3209011702950012',
                'nik_karyawan' => 'PION-EMP-011',
                'email' => 'deni.pratama@example.com',
                'phone' => '081322110010',
                'department' => 'Produksi & Manufaktur',
                'birth_place' => 'Cirebon',
                'birth_date' => '1995-02-17',
                'joint_date' => '2022-08-15',
                'address' => 'Jl. Kartini No. 56, Cirebon',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'SMA/SMK',
            ],
            [
                'name' => 'Christine Natalia',
                'username' => 'christine',
                'nik_ktp' => '3173064212940013',
                'nik_karyawan' => 'PION-EMP-012',
                'email' => 'christine@example.com',
                'phone' => '081322110011',
                'department' => 'Purchasing & Pengadaan',
                'birth_place' => 'Medan',
                'birth_date' => '1994-12-02',
                'joint_date' => '2021-02-01',
                'address' => 'Jl. Kelapa Gading Boulevard No. 18, Jakarta Utara',
                'gender' => 'female',
                'religion' => 'Katolik',
                'education' => 'S1',
            ],
            [
                'name' => 'Hendro Prasetyo',
                'username' => 'hendro',
                'nik_ktp' => '3578010505920014',
                'nik_karyawan' => 'PION-EMP-013',
                'email' => 'hendro.p@example.com',
                'phone' => '081322110012',
                'department' => 'Operasional & Fasilitas',
                'birth_place' => 'Surabaya',
                'birth_date' => '1992-05-05',
                'joint_date' => '2020-10-10',
                'address' => 'Jl. Raya Darmo No. 80, Surabaya',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'D3',
            ],
        ];

        $allUsers = [$abghi];
        foreach ($karyawanList as $idx => $k) {
            $createdUser = User::updateOrCreate(
                ['username' => $k['username']],
                [
                    'name' => $k['name'],
                    'nik_ktp' => $k['nik_ktp'],
                    'nik_karyawan' => $k['nik_karyawan'],
                    'kta_number' => '20240104012' . str_pad($idx + 2, 3, '0', STR_PAD_LEFT),
                    'barcode_number' => '8991234567' . str_pad($idx + 2, 2, '0', STR_PAD_LEFT),
                    'email' => $k['email'],
                    'phone' => $k['phone'],
                    'department' => $k['department'],
                    'birth_place' => $k['birth_place'],
                    'birth_date' => $k['birth_date'],
                    'joint_date' => $k['joint_date'],
                    'address' => $k['address'],
                    'gender' => $k['gender'],
                    'religion' => $k['religion'],
                    'education' => $k['education'],
                    'role' => 'user',
                    'password' => Hash::make('password123'),
                    'password_hint' => 'password123',
                    'pin' => Hash::make('123456'),
                    'pin_hint' => '123456',
                ]
            );
            $allUsers[] = $createdUser;
        }

        // ========================================================
        // 2. SEED INFORMATION (Berita & Pengumuman Serikat)
        // ========================================================
        $informations = [
            [
                'type' => 'Pengumuman',
                'title' => 'Hasil Kesepakatan Bipartit: Penyesuaian Insentif Shift & UMK 2026',
                'description' => 'Disampaikan kepada seluruh anggota SP PION bahwa tim advokasi telah menyelesaikan perundingan Bipartit dengan manajemen. Disepakati kenaikan tunjangan kehadiran 10% dan insentif shift malam efektif mulai awal bulan depan.',
            ],
            [
                'type' => 'Kegiatan',
                'title' => 'Penyelenggaraan Rapat Kerja Anggota Tahunan (RKAT) SP PION Ke-V',
                'description' => 'Pengurus mengundang perwakilan unit kerja untuk menghadiri RKAT yang akan membahas evaluasi program kerja tahun 2025 serta penetapan arah kebijakan strategis organisasi tahun 2026.',
            ],
            [
                'type' => 'Berita',
                'title' => 'Pembaruan Dokumen Perjanjian Kerja Bersama (PKB) Periode 2026-2028',
                'description' => 'Draft naskah PKB terbaru kini telah disetujui bersama dan didaftarkan ke Dinas Tenaga Kerja. Seluruh anggota dapat mengunduh salinan resmi pada menu Regulasi Organisasi.',
            ],
            [
                'type' => 'Info Penting',
                'title' => 'Sosialisasi Program Jaminan Pensiun & Manfaat JHT BPJS Ketenagakerjaan',
                'description' => 'Workshop edukasi jaminan sosial tenaga kerja akan diselenggarakan pada akhir pekan ini secara hybrid melalui Zoom dan di Aula Pertemuan SP PION.',
            ],
            [
                'type' => 'Pemberitahuan',
                'title' => 'Jadwal Libur Resmi & Pembagian Paket Sembako Hari Raya Idul Fitri',
                'description' => 'Berikut adalah jadwal cuti bersama operasional serta mekanisme pembagian paket berkah sembako untuk seluruh anggota aktif SP PION di posko serikat.',
            ],
        ];

        foreach ($informations as $info) {
            Information::firstOrCreate(
                ['title' => $info['title']],
                [
                    'type' => $info['type'],
                    'description' => $info['description'],
                ]
            );
        }

        // ========================================================
        // 3. SEED ORGANIZATIONS (Struktur Organisasi)
        // ========================================================
        $organizations = [
            [
                'type' => 'Pengurus Harian',
                'title' => 'Ketua Umum Serikat Pekerja PION',
                'description' => 'Memimpin jalannya organisasi secara menyeluruh, menetapkan kebijakan strategis, dan mewakili serikat pekerja dalam perundingan tripartit maupun bipartit nasional.',
            ],
            [
                'type' => 'Pengurus Harian',
                'title' => 'Sekretaris Umum & Administrasi',
                'description' => 'Mengelola korespondensi resmi, pendataan keanggotaan, arsip regulasi ketenagakerjaan, serta notulensi rapat kerja serikat pekerja.',
            ],
            [
                'type' => 'Pengurus Harian',
                'title' => 'Bendahara Umum & Keuangan Kas',
                'description' => 'Bertanggung jawab penuh atas pengelolaan kas iuran anggota, pelaporan akuntansi transparan, dan alokasi dana solidaritas serikat.',
            ],
            [
                'type' => 'Bidang Fungsional',
                'title' => 'Bidang Advokasi Hukum & Pembelaan Anggota',
                'description' => 'Memberikan pendampingan hukum, bantuan mediasi perselisihan hubungan industrial, dan pengawasan penegakan norma ketenagakerjaan.',
            ],
            [
                'type' => 'Bidang Fungsional',
                'title' => 'Bidang Kesejahteraan & Jaminan Sosial',
                'description' => 'Fasilitasi program kesehatan anggota, klaim BPJS Ketenagakerjaan, santunan dana sosial, dan koperasi karyawan.',
            ],
            [
                'type' => 'Bidang Fungsional',
                'title' => 'Bidang Pendidikan, Pelatihan & Kaderisasi',
                'description' => 'Menyelenggarakan kursus kepemimpinan buruh, seminar hukum ketenagakerjaan, dan pembinaan kader militan serikat.',
            ],
        ];

        foreach ($organizations as $org) {
            Organization::firstOrCreate(
                ['title' => $org['title']],
                [
                    'type' => $org['type'],
                    'description' => $org['description'],
                ]
            );
        }

        // ========================================================
        // 4. SEED SOCIALS (Kegiatan Sosial & Solidaritas)
        // ========================================================
        $socials = [
            [
                'type' => 'Kemanusiaan',
                'title' => 'Aksi Donor Darah Peduli Sesama SP PION Bekerjasama dengan PMI',
                'description' => 'Kegiatan rutin donor darah yang berhasil mengumpulkan lebih dari 120 kantong darah dari anggota serikat dan masyarakat sekitar pabrik.',
            ],
            [
                'type' => 'Pendidikan',
                'title' => 'Penyerahan Bantuan Beasiswa Prestasi untuk Putra-Putri Anggota',
                'description' => 'Penyaluran beasiswa bagi 35 anak anggota serikat berprestasi dari jenjang SD hingga Perguruan Tinggi sebagai bentuk kepedulian organisasi.',
            ],
            [
                'type' => 'Bakti Sosial',
                'title' => 'Penyaluran Bantuan Sembako & Renovasi Rumah Anggota Terdampak Banjir',
                'description' => 'Aksi tanggap bencana solidaritas SP PION dalam menyalurkan bantuan logistik darurat dan perbaikan tempat tinggal anggota di wilayah Jabodetabek.',
            ],
            [
                'type' => 'Kesehatan',
                'title' => 'Program Pemeriksaan Kesehatan Gratis & Senam Jantung Sehat',
                'description' => 'Pemeriksaan tensi darah, kolesterol, gula darah, dan konsultasi dokter gratis bagi anggota dan keluarganya setiap triwulan.',
            ],
        ];

        foreach ($socials as $soc) {
            Social::firstOrCreate(
                ['title' => $soc['title']],
                [
                    'type' => $soc['type'],
                    'description' => $soc['description'],
                ]
            );
        }

        // ========================================================
        // 5. SEED FINANCIALS (Laporan Keuangan Kas Serikat)
        // ========================================================
        $financials = [
            [
                'type' => 'Pemasukan',
                'title' => 'Rekapitulasi Iuran Rutin Anggota Periode Januari 2026',
                'description' => 'Total penerimaan iuran wajib anggota bulan Januari 2026 dari seluruh departemen operasional pabrik sebesar Rp 45.800.000.',
            ],
            [
                'type' => 'Pemasukan',
                'title' => 'Penerimaan Dana Kas Solidaritas & Donasi Sukarela Anggota',
                'description' => 'Penerimaan dana spontanitas anggota untuk pos dana darurat dan bantuan bencana alam sebesar Rp 8.500.000.',
            ],
            [
                'type' => 'Pengeluaran',
                'title' => 'Penyaluran Dana Santunan Duka Cita & Bantuan Rawat Inap Anggota',
                'description' => 'Realisasi santunan untuk 4 anggota yang mengalami musibah sakit dan duka cita keluarga inti sebesar Rp 6.000.000.',
            ],
            [
                'type' => 'Pengeluaran',
                'title' => 'Biaya Konsumsi & Akomodasi Rapat Kerja Tahunan (RKAT) 2026',
                'description' => 'Pengeluaran operasional kegiatan rapat kerja tahunan pengurus dan perwakilan unit kerja sebesar Rp 5.250.000.',
            ],
            [
                'type' => 'Pengeluaran',
                'title' => 'Pengadaan KTA Fisik & Atribut Seragam Resmi Anggota Baru',
                'description' => 'Biaya pencetakan kartu tanda anggota (KTA) barcode, rompi, dan pin resmi organisasi SP PION sebesar Rp 7.800.000.',
            ],
        ];

        foreach ($financials as $fin) {
            Financial::firstOrCreate(
                ['title' => $fin['title']],
                [
                    'type' => $fin['type'],
                    'description' => $fin['description'],
                ]
            );
        }

        // ========================================================
        // 6. SEED LEARNINGS (Modul Pembelajaran & Ketenagakerjaan)
        // ========================================================
        $learnings = [
            [
                'type' => 'Hukum Kerja',
                'title' => 'Panduan Hak-Hak Normatif Pekerja Sesuai Regulasi Ketenagakerjaan',
                'description' => 'Materi pembelajaran komprehensif mengenai waktu kerja, waktu istirahat, upah lembur, hak cuti tahunan, dan hak perlindungan upah normatif.',
            ],
            [
                'type' => 'Advokasi',
                'title' => 'Modul Kiat Berunding & Teknik Negosiasi Perjanjian Kerja Bersama (PKB)',
                'description' => 'Strategi menyusun argumen berbasis data, analisis neraca perusahaan, dan seni diplomasi dalam forum Bipartit untuk mencapai mufakat.',
            ],
            [
                'type' => 'K3 Industri',
                'title' => 'Standar Keselamatan & Kesehatan Kerja (K3) di Lingkungan Manufaktur',
                'description' => 'Pedoman wajib identifikasi bahaya kerja, penggunaan Alat Pelindung Diri (APD) bersertifikasi, dan prosedur evakuasi tanggap darurat pabrik.',
            ],
            [
                'type' => 'Organisasi',
                'title' => 'Kepemimpinan Serikat & Manajemen Organisasi Buruh Modern',
                'description' => 'Prinsip kepemimpinan demokratis, tata kelola serikat yang akuntabel, serta komunikasi persuasif bagi calon pengurus masa depan.',
            ],
        ];

        foreach ($learnings as $lrn) {
            Learning::firstOrCreate(
                ['title' => $lrn['title']],
                [
                    'type' => $lrn['type'],
                    'description' => $lrn['description'],
                ]
            );
        }

        // ========================================================
        // 7. SEED UNIONS (Regulasi & Dokumen Resmi Serikat)
        // ========================================================
        $unions = [
            [
                'type' => 'Perjanjian Resmi',
                'title' => 'Buku Naskah Perjanjian Kerja Bersama (PKB) SP PION 2024-2026',
                'description' => 'Dokumen sah hasil kesepakatan antara SP PION dan Manajemen Perusahaan yang memuat hak dan kewajiban kedua belah pihak secara mengikat.',
            ],
            [
                'type' => 'Konstitusi Organisasi',
                'title' => 'Anggaran Dasar & Anggaran Rumah Tangga (AD/ART) SP PION',
                'description' => 'Pedoman dasar arah organisasi, asas perjuangan, struktur kepengurusan, hak anggota, dan mekanisme pengambilan keputusan tertinggi.',
            ],
            [
                'type' => 'Legalitas Hukum',
                'title' => 'Surat Bukti Pencatatan Serikat Pekerja dari Dinas Tenaga Kerja',
                'description' => 'Legalitas resmi pengakuan serikat pekerja yang diterbitkan oleh Disnaker Kota sesuai Undang-Undang No. 21 Tahun 2000.',
            ],
            [
                'type' => 'SOP Organisasi',
                'title' => 'SOP Penanganan Keluh Kesah & Mekanisme Pendampingan Advokasi Anggota',
                'description' => 'Tahapan baku bagi anggota untuk menyampaikan keberatan atau perselisihan kerja kepada perwakilan serikat kerja unit.',
            ],
        ];

        foreach ($unions as $un) {
            Union::firstOrCreate(
                ['title' => $un['title']],
                [
                    'type' => $un['type'],
                    'description' => $un['description'],
                ]
            );
        }

        // ========================================================
        // 8. SEED VISIONS (Visi & Misi Organisasi)
        // ========================================================
        Vision::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Menjadi serikat pekerja yang mandiri, demokratis, profesional, dan terpercaya dalam memperjuangkan kesejahteraan, martabat, serta kepastian kerja bagi seluruh anggota dan keluarganya.',
                'subtitle' => "1. Menegakkan hak-hak normatif dan memperjuangkan peningkatan kesejahteraan anggota beserta keluarga secara berkelanjutan.\n2. Mengembangkan hubungan industrial yang harmonis, dinamis, dan berkeadilan melalui forum dialog sosial dan Bipartit yang konstruktif.\n3. Meningkatkan kompetensi, wawasan hukum ketenagakerjaan, dan soliditas solidaritas seluruh anggota.\n4. Mendorong tata kelola organisasi serikat yang transparan, modern, akuntabel, dan bebas dari intervensi.",
            ]
        );

        // ========================================================
        // 9. SEED VOTES & OPTIONS (E-Voting Ketua & Program)
        // ========================================================
        $vote = Vote::firstOrCreate(
            ['title' => 'Pemilihan Ketua Umum SP PION Masa Bakti 2026 - 2029'],
            [
                'description' => 'Gunakan hak pilih Anda secara jujur, bebas, dan rahasia untuk menentukan nahkoda kepemimpinan Serikat Pekerja PION periode 3 tahun ke depan.',
                'is_active' => true,
            ]
        );

        // Cari beberapa user untuk dijadikan kandidat
        $candidate1 = User::where('username', 'budisantoso')->first() ?? $abghi;
        $candidate2 = User::where('username', 'intanpermata')->first() ?? $abghi;
        $candidate3 = User::where('username', 'rianhidayat')->first() ?? $abghi;

        $opt1 = VoteOption::firstOrCreate(
            ['vote_id' => $vote->id, 'user_id' => $candidate1->id],
            [
                'label' => 'Kandidat 01: ' . $candidate1->name,
                'vision' => 'Fokus pada reformasi upah riil, jaminan keselamatan kerja, dan digitalisasi layanan advokasi anggota 24 jam.',
            ]
        );

        $opt2 = VoteOption::firstOrCreate(
            ['vote_id' => $vote->id, 'user_id' => $candidate2->id],
            [
                'label' => 'Kandidat 02: ' . $candidate2->name,
                'vision' => 'Memperkuat posisi tawar buruh dalam PKB, transparansi penuh dana kas serikat, dan program beasiswa anak buruh berkesinambungan.',
            ]
        );

        $opt3 = VoteOption::firstOrCreate(
            ['vote_id' => $vote->id, 'user_id' => $candidate3->id],
            [
                'label' => 'Kandidat 03: ' . $candidate3->name,
                'vision' => 'Kemitraan konstruktif dengan manajemen untuk peningkatan produktivitas yang berdampak langsung pada bonus tahunan karyawan.',
            ]
        );

        // Seed Vote Results (Hasil Voting Nyata dari Dummy Karyawan)
        $options = [$opt1, $opt2, $opt3];
        foreach ($allUsers as $index => $u) {
            // Sebar vote acak tapi realistis
            $chosenOption = $options[$index % count($options)];
            VoteResult::updateOrCreate(
                ['vote_id' => $vote->id, 'user_id' => $u->id],
                ['vote_option_id' => $chosenOption->id]
            );
        }

        // ========================================================
        // 10. SEED BROADCASTS (Siaran Pesan Massal)
        // ========================================================
        $broadcast1 = Broadcast::firstOrCreate(
            ['title' => 'Pengingat: Batas Akhir Voting Pemilihan Ketua Umum SP PION'],
            [
                'body' => 'Diberitahukan kepada seluruh anggota bahwa e-voting Pemilihan Ketua Umum akan ditutup besok pukul 17.00 WIB. Pastikan Anda telah menyalurkan suara di portal resmi.',
            ]
        );

        $broadcast2 = Broadcast::firstOrCreate(
            ['title' => 'Sosialisasi Pemberlakuan Sistem Lembur Terintegrasi'],
            [
                'body' => 'Berdasarkan kesepakatan Bipartit terbaru, seluruh jam lembur akan dicatat secara real-time pada sistem presensi digital mulai tanggal 1 bulan depan.',
            ]
        );

        // Attach broadcast to users
        $userIds = collect($allUsers)->pluck('id')->toArray();
        $broadcast1->users()->syncWithoutDetaching($userIds);
        $broadcast2->users()->syncWithoutDetaching($userIds);

        // ========================================================
        // 11. SEED TICKETS & REPLIES (Aspirasi & Keluhan Anggota)
        // ========================================================
        $ticket1 = Ticket::firstOrCreate(
            ['ticket_number' => 'TCK-202602-001'],
            [
                'user_id' => $abghi->id,
                'type' => 'suggestion',
                'title' => 'Usulan Peningkatan Fasilitas Akses Wi-Fi & Meja Kerja di Posko Serikat',
                'description' => 'Mohon dipertimbangkan untuk upgrade bandwidth internet di ruang sekretariat serikat agar proses input data keanggotaan dan sesi zoom edukasi anggota berjalan lancar tanpa kendala.',
                'status' => 'responded',
                'created_at' => now()->subDays(5),
            ]
        );

        TicketReply::firstOrCreate(
            ['ticket_id' => $ticket1->id, 'user_id' => $admin->id],
            [
                'message' => 'Terima kasih atas masukannya Mas Abghi Fareihan. Pengurus telah menyetujui pengadaan router baru dan penambahan bandwidth dari provider. Implementasi akan dilakukan minggu ini.',
                'created_at' => now()->subDays(3),
            ]
        );

        $ticket2 = Ticket::firstOrCreate(
            ['ticket_number' => 'TCK-202602-002'],
            [
                'user_id' => $candidate1->id,
                'type' => 'report',
                'title' => 'Laporan Kerusakan Pendingin Udara (AC) di Ruang Istirahat Produksi',
                'description' => 'AC di ruang istirahat lantai 2 gedung fabrikasi sudah tidak dingin selama 3 hari terakhir sehingga rekan-rekan shift siang merasa gerah saat istirahat kerja.',
                'status' => 'done',
                'created_at' => now()->subDays(10),
            ]
        );

        TicketReply::firstOrCreate(
            ['ticket_id' => $ticket2->id, 'user_id' => $admin->id],
            [
                'message' => 'Laporan sudah diteruskan ke tim General Affair (GA) dan teknisi telah melakukan perbaikan kompresor serta pembersihan filter. Saat ini AC sudah berfungsi normal kembali.',
                'created_at' => now()->subDays(8),
            ]
        );

        $ticket3 = Ticket::firstOrCreate(
            ['ticket_number' => 'TCK-202602-003'],
            [
                'user_id' => $allUsers[2]->id ?? $abghi->id,
                'type' => 'question',
                'title' => 'Pertanyaan Prosedur Klaim Bantuan Kacamata SP PION',
                'description' => 'Apakah resep dokter dari klinik BPJS dapat langsung digunakan untuk klaim reimbursement kacamata di kantor sekretariat SP PION? Mohon panduan persyaratannya.',
                'status' => 'pending',
                'created_at' => now()->subDays(1),
            ]
        );

        // ========================================================
        // 12. SEED MEMBER REGISTRATIONS (Pendaftaran Anggota Baru)
        // ========================================================
        $registrations = [
            [
                'referrer_id' => $abghi->id,
                'name' => 'Fajar Nugraha',
                'nik_ktp' => '3273111204990015',
                'nik_karyawan' => 'PION-NEW-001',
                'department' => 'Produksi & Manufaktur',
                'birth_place' => 'Bandung',
                'birth_date' => '1999-04-12',
                'address' => 'Jl. Moch Toha No. 115, Bandung',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'SMA/SMK',
                'phone' => '082122334401',
                'status' => 'pending',
            ],
            [
                'referrer_id' => $abghi->id,
                'name' => 'Putri Wulandari',
                'nik_ktp' => '3273155806980016',
                'nik_karyawan' => 'PION-NEW-002',
                'department' => 'Quality Control (QC)',
                'birth_place' => 'Cimahi',
                'birth_date' => '1998-06-18',
                'address' => 'Jl. Kolonel Masturi No. 42, Cimahi',
                'gender' => 'female',
                'religion' => 'Islam',
                'education' => 'D3',
                'phone' => '082122334402',
                'status' => 'approved',
            ],
            [
                'referrer_id' => $allUsers[1]->id ?? $abghi->id,
                'name' => 'Rizky Pratama',
                'nik_ktp' => '3273200109970017',
                'nik_karyawan' => 'PION-NEW-003',
                'department' => 'Logistik & Pergudangan',
                'birth_place' => 'Garut',
                'birth_date' => '1997-09-01',
                'address' => 'Jl. Soekarno Hatta No. 500, Bandung',
                'gender' => 'male',
                'religion' => 'Islam',
                'education' => 'SMA/SMK',
                'phone' => '082122334403',
                'status' => 'rejected',
            ],
        ];

        foreach ($registrations as $reg) {
            MemberRegistration::firstOrCreate(
                ['nik_ktp' => $reg['nik_ktp']],
                $reg
            );
        }
    }
}
