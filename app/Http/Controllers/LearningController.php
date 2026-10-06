<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Student;
use App\Models\Badge;
use App\Models\Announcement;
use App\Models\ParentSetting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LearningController extends Controller
{
    /**
     * Static data fallback definition (used for initial seeding)
     */
    public static function getSubjectsData()
    {
        return [
            'matematika' => [
                'id' => 'matematika',
                'name' => 'Matematika',
                'class' => 'Kelas 4 - 6',
                'icon' => '📐',
                'color' => '#3b82f6',
                'bg_gradient' => 'linear-gradient(135deg, #1e3a8a, #3b82f6)',
                'summary' => 'Belajar pecahan, bangun datar, FPB & KPK, dan trik berhitung cepat tanpa pusing!',
                'progress' => 75,
                'completed_topics' => 6,
                'total_topics' => 8,
                'topics' => [
                    [
                        'id' => 'pecahan-dasar',
                        'title' => 'Pecahan Senilai & Desimal',
                        'duration' => '3 Menit',
                        'difficulty' => 'Mudah',
                        'video_title' => 'Animasi: Membagi Pizza Jadi Pecahan Senilai',
                        'video_desc' => 'Lihat bagaimana 1/2 potong pizza besarnya sama persis dengan 2/4 dan 4/8!',
                        'video_url' => 'https://www.youtube.com/watch?v=knc_bMqm8lE',
                        'micro_steps' => [
                            ['title' => 'Apa itu Pecahan?', 'content' => 'Pecahan adalah bagian dari satu kesatuan utuh. Angka di atas disebut <b>Pembilang</b> (bagian yang kita ambil), dan angka di bawah disebut <b>Penyebut</b> (jumlah total potongan).', 'highlight' => 'Contoh: 1/4 pizza berarti 1 potong dari total 4 potong.'],
                            ['title' => 'Pecahan Senilai', 'content' => 'Jika pembilang dan penyebut dikalikan atau dibagi dengan angka yang sama, nilainya tidak akan berubah! Contoh: 1/2 x 2/2 = 2/4.', 'highlight' => 'Trik Cepat: Kalikan silang untuk mengecek apakah dua pecahan senilai.'],
                            ['title' => 'Mengubah ke Desimal', 'content' => 'Ubah penyebut menjadi 10, 100, atau 1000. 1/2 = 5/10 = 0.5. Begitu juga dengan 1/4 = 25/100 = 0.25.', 'highlight' => '1/2 = 0.5 | 1/4 = 0.25 | 3/4 = 0.75']
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Bentuk pecahan senilai dari 2/3 jika pembilangnya dikalikan 3 adalah...',
                                'options' => ['4/6', '6/9', '5/6', '6/3'],
                                'answer' => 1,
                                'explanation' => 'Hebat! Jika pembilang 2 dikali 3 = 6, maka penyebut 3 juga harus dikali 3 = 9. Jadi senilainya adalah 6/9.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Bentuk desimal dari pecahan 3/4 adalah...',
                                'options' => ['0.34', '0.75', '0.50', '0.25'],
                                'answer' => 1,
                                'explanation' => 'Benar sekali! 3/4 = (3 × 25) / (4 × 25) = 75/100 = 0.75.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Ibu memotong kue menjadi 8 bagian sama besar. Budi memakan 2 bagian, lalu Siti memakan 1/4 bagian kue. Berapa sisa kue Ibu sekarang?',
                                'options' => ['1/2 bagian (4 potong)', '3/8 bagian (3 potong)', '1/4 bagian (2 potong)', '5/8 bagian (5 potong)'],
                                'answer' => 0,
                                'explanation' => 'Budi makan 2/8 kue. Siti makan 1/4 = 2/8 kue. Total dimakan = 2/8 + 2/8 = 4/8 kue (atau 1/2 kue). Jadi sisa kue = 8/8 - 4/8 = 4/8 atau 1/2 bagian kue!'
                            ]
                        ]
                    ],
                    [
                        'id' => 'bangun-datar',
                        'title' => 'Keliling & Luas Persegi Panjang',
                        'duration' => '4 Menit',
                        'difficulty' => 'Sedang',
                        'video_title' => 'Visualisasi: Membentangkan Rumus Keliling & Luas',
                        'video_desc' => 'Pahami perbedaan menghitung pagar keliling vs menghitung luas lantai ubin.',
                        'video_url' => 'https://www.youtube.com/watch?v=Jm-8Qz9jO5Q',
                        'micro_steps' => [
                            ['title' => 'Keliling (Pagar Luar)', 'content' => 'Keliling adalah panjang seluruh tepi luar bangun. Rumus: 2 × (Panjang + Lebar).', 'highlight' => 'Bayangkan berlari mengelilingi lapangan bola.'],
                            ['title' => 'Luas (Isi Dalam)', 'content' => 'Luas adalah besar bidang datar di dalam tepian. Rumus: Panjang × Lebar.', 'highlight' => 'Bayangkan menghitung jumlah ubin lantai di dalam ruangan.']
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Sebuah persegi memiliki sisi 6 cm. Luasnya adalah...',
                                'options' => ['24 cm²', '36 cm²', '12 cm²', '18 cm²'],
                                'answer' => 1,
                                'explanation' => 'Luas persegi = sisi × sisi = 6 × 6 = 36 cm².'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Persegi panjang berukuran panjang 10 cm dan lebar 4 cm. Berapakah kelilingnya?',
                                'options' => ['28 cm', '40 cm', '14 cm', '20 cm'],
                                'answer' => 0,
                                'explanation' => 'Keliling = 2 × (p + l) = 2 × (10 + 4) = 2 × 14 = 28 cm.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Sebuah kebun berbentuk persegi panjang berluas 72 m² dengan panjang 12 m. Jika sekeliling kebun dipasangi kawat 2 lapis, berapa panjang kawat yang dibutuhkan?',
                                'options' => ['36 meter', '72 meter', '18 meter', '54 meter'],
                                'answer' => 1,
                                'explanation' => 'Lebar kebun = Luas / Panjang = 72 / 12 = 6 m. Keliling kebun = 2 × (12 + 6) = 36 m. Karena dipasang 2 lapis, kawat = 36 × 2 = 72 meter!'
                            ]
                        ]
                    ]
                ]
            ],
            'ipa' => [
                'id' => 'ipa',
                'name' => 'IPA (Ilmu Pengetahuan Alam)',
                'class' => 'Kelas 4 - 6',
                'icon' => '🔬',
                'color' => '#10b981',
                'bg_gradient' => 'linear-gradient(135deg, #064e3b, #10b981)',
                'summary' => 'Jelajahi keajaiban tubuh manusia, rantai makanan, fotosintesis, dan tata surya!',
                'progress' => 88,
                'completed_topics' => 7,
                'total_topics' => 8,
                'topics' => [
                    [
                        'id' => 'sistem-pencernaan',
                        'title' => 'Petualangan Makanan di Tubuh Kita',
                        'duration' => '3 Menit',
                        'difficulty' => 'Mudah',
                        'video_title' => 'Animasi 3D: Perjalanan Apel dari Mulut ke Usus',
                        'video_desc' => 'Tonton bagaimana enzim di ludah dan asam lambung mengubah makanan jadi energi super.',
                        'video_url' => 'https://www.youtube.com/watch?v=gT8Z0sI8Xsc',
                        'micro_steps' => [
                            ['title' => 'Pintu Gerbang: Mulut', 'content' => 'Makanan dikunyah gigi (mekanik) dan dibasahi air liur dengan enzim ptialin (kimiawi) agar mudah ditelan.', 'highlight' => 'Enzim ptialin mengubah karbohidrat jadi zat gula manis!'],
                            ['title' => 'Penggiling Utama: Lambung', 'content' => 'Otot lambung meremas makanan dengan asam lambung (HCl) yang membunuh kuman penyakit.', 'highlight' => 'Asam lambung sangat kuat untuk menjaga tubuh dari bakteri.'],
                            ['title' => 'Penyerap Energi: Usus Halus', 'content' => 'Sari-sari nutrisi penting diserap masuk ke aliran darah untuk diedarkan ke seluruh tubuh.', 'highlight' => 'Usus besar kemudian menyerap sisa air hingga tersisa ampas.']
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Organ pencernaan yang berfungsi mengunyah makanan secara mekanik adalah...',
                                'options' => ['Kerongkongan', 'Mulut & Gigi', 'Lambung', 'Hati'],
                                'answer' => 1,
                                'explanation' => 'Tepat! Di mulut, gigi memotong dan menghancurkan makanan secara mekanik.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Enzim ptialin yang terdapat di dalam air ludah berfungsi mengubah amilum menjadi...',
                                'options' => ['Protein', 'Glukosa (Gula sederhana)', 'Lemak', 'Vitamin'],
                                'answer' => 1,
                                'explanation' => 'Betul! Itulah sebabnya nasi yang dikunyah lama-lama terasa manis di mulut.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Jika seseorang mengalami dehidrasi karena penyerapan air yang terganggu di saluran pencernaan, organ yang mengalami gangguan fungsi utama adalah...',
                                'options' => ['Usus Besar', 'Lambung', 'Kerongkongan', 'Usus Halus'],
                                'answer' => 0,
                                'explanation' => 'Luar biasa! Usus besar (kolon) adalah organ utama penyerap air dan garam mineral dari sisa makanan. Jika terganggu, kotoran menjadi encer (diare) atau tubuh kehilangan air.'
                            ]
                        ]
                    ]
                ]
            ],
            'ips' => [
                'id' => 'ips',
                'name' => 'IPS (Ilmu Pengetahuan Sosial)',
                'class' => 'Kelas 4 - 6',
                'icon' => '🌏',
                'color' => '#f59e0b',
                'bg_gradient' => 'linear-gradient(135deg, #78350f, #d97706)',
                'summary' => 'Jelajah kekayaan alam Indonesia, peta interaktif, suku bangsa, dan sejarah pahlawan!',
                'progress' => 60,
                'completed_topics' => 3,
                'total_topics' => 5,
                'topics' => [
                    [
                        'id' => 'keragaman-budaya',
                        'title' => 'Bhinneka Tunggal Ika: Keragaman Budaya',
                        'duration' => '3 Menit',
                        'difficulty' => 'Mudah',
                        'video_title' => 'Tur Wisata: Rumah Adat & Tarian Nusantara',
                        'video_desc' => 'Kenali Rumah Gadang di Minang, Tongkonan di Toraja, dan Tari Saman di Aceh.',
                        'video_url' => 'https://www.youtube.com/watch?v=ZfJk2e_4o0E',
                        'micro_steps' => [
                            ['title' => 'Rumah Adat Khas', 'content' => 'Setiap suku di Indonesia memiliki arsitektur rumah adat yang dirancang sesuai alam dan adat istiadatnya.', 'highlight' => 'Rumah Gadang berciri atap melengkung runcing seperti tanduk kerbau.'],
                            ['title' => 'Tarian Tradisional', 'content' => 'Tari daerah bukan sekadar hiburan, melainkan ungkapan rasa syukur dan sambutan kehormatan.', 'highlight' => 'Tari Kecak (Bali), Tari Saman (Aceh), Tari Jaipong (Jawa Barat).'],
                            ['title' => 'Sikap Toleransi', 'content' => 'Meskipun berbeda suku, agama, dan budaya, kita tetap satu bangsa Indonesia sesuai semboyan Bhinneka Tunggal Ika.', 'highlight' => 'Berbeda-beda tetapi tetap satu jua!']
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Rumah Gadang dengan atap menyerupai tanduk kerbau adalah rumah adat dari suku...',
                                'options' => ['Minangkabau (Sumatera Barat)', 'Jawa', 'Bugis', 'Dayak'],
                                'answer' => 0,
                                'explanation' => 'Benar sekali! Rumah Gadang berasal dari ranah Minangkabau di Sumatera Barat.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Tari Saman yang terkenal dengan tepukan ritmis yang sangat kompak berasal dari daerah...',
                                'options' => ['Aceh', 'Yogyakarta', 'Kalimantan Timur', 'Papua'],
                                'answer' => 0,
                                'explanation' => 'Mantap! Tari Saman dari suku Gayo di Aceh telah diakui UNESCO sebagai warisan dunia.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Secara geografis Indonesia terletak di antara dua benua dan dua samudra. Posisi silang strategis ini menyebabkan Indonesia menjadi...',
                                'options' => ['Jalur lalu lintas perdagangan internasional', 'Negara dengan satu iklim dingin', 'Wilayah yang terisolasi dari budaya luar', 'Negara tanpa keanekaragaman hayati'],
                                'answer' => 0,
                                'explanation' => 'Tepat! Terletak di antara Samudra Hindia - Pasifik dan Benua Asia - Australia menjadikan Indonesia poros maritim dan jalur dagang utama.'
                            ]
                        ]
                    ]
                ]
            ],
            'bahasa-indonesia' => [
                'id' => 'bahasa-indonesia',
                'name' => 'Bahasa Indonesia',
                'class' => 'Kelas 4 - 6',
                'icon' => '📖',
                'color' => '#ef4444',
                'bg_gradient' => 'linear-gradient(135deg, #7f1d1d, #ef4444)',
                'summary' => 'Kuasai ide pokok bacaan, dongeng fiksi, pantun berirama, dan cara menulis karangan seru!',
                'progress' => 80,
                'completed_topics' => 4,
                'total_topics' => 5,
                'topics' => [
                    [
                        'id' => 'ide-pokok',
                        'title' => 'Menemukan Ide Pokok dalam Paragraf',
                        'duration' => '3 Menit',
                        'difficulty' => 'Mudah',
                        'video_title' => 'Trik Detektif: Cara Kilat Temukan Kalimat Utama',
                        'video_desc' => 'Bedakan antara Ide Pokok (Inti Masalah) dengan Kalimat Pengembang/Penjelas.',
                        'video_url' => 'https://www.youtube.com/watch?v=D43X9QYQ1vY',
                        'micro_steps' => [
                            ['title' => 'Apa itu Ide Pokok?', 'content' => 'Ide pokok adalah gagasan atau pesan inti yang menjadi dasar pengembangan sebuah paragraf.', 'highlight' => 'Sering disebut juga Gagasan Pokok atau Pikiran Utama.'],
                            ['title' => 'Di Mana Letaknya?', 'content' => 'Bisa di awal paragraf (Deduktif), di akhir paragraf (Induktif), atau di awal dan akhir (Campuran).', 'highlight' => 'Biasanya ada pada kalimat yang paling umum merangkum seluruh teks.'],
                            ['title' => 'Langkah Menemukan', 'content' => 'Baca paragraf dengan saksama, tandai kata kunci yang sering diulang, dan cari kalimat utama.', 'highlight' => 'Tanyakan: Teks ini sebenarnya sedang membahas tentang apa?']
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Paragraf yang letak gagasan utamanya berada di awal paragraf disebut paragraf...',
                                'options' => ['Deduktif', 'Induktif', 'Campuran', 'Naratif'],
                                'answer' => 0,
                                'explanation' => 'Tepat sekali! Paragraf Deduktif dimulai dari ide umum di awal, lalu diperjelas kalimat-kalimat rincian.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => '"Hutan bakau memiliki manfaat besar bagi garis pantai. Hutan ini dapat mencegah abrasi dari gelombang ombak laut. Selain itu, bakau menjadi sarang bertelur bagi ikan kecil." Ide pokok paragraf di atas adalah...',
                                'options' => ['Manfaat besar hutan bakau bagi pantai', 'Ombak laut yang sangat tinggi', 'Jenis-jenis ikan di hutan bakau', 'Proses penanaman pohon bakau'],
                                'answer' => 0,
                                'explanation' => 'Benar! Kalimat pertama adalah gagasan pokok yang memayungi seluruh penjelasan kalimat berikutnya.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Dalam sebuah pantun nasihat dengan rima a-b-a-b, pesan atau isi pantun selalu terdapat pada baris...',
                                'options' => ['Baris ke-3 dan ke-4', 'Baris ke-1 dan ke-2', 'Baris ke-1 dan ke-4', 'Hanya di baris ke-2'],
                                'answer' => 0,
                                'explanation' => 'Hebat! Baris 1-2 adalah sampiran, sedangkan baris 3-4 adalah isi yang memuat pesan moral atau nasihat.'
                            ]
                        ]
                    ]
                ]
            ],
            'bahasa-inggris' => [
                'id' => 'bahasa-inggris',
                'name' => 'Bahasa Inggris (English for Kids)',
                'class' => 'Kelas 4 - 6',
                'icon' => '🔤',
                'color' => '#8b5cf6',
                'bg_gradient' => 'linear-gradient(135deg, #4c1d95, #8b5cf6)',
                'summary' => 'Learn daily expressions, telling time, wild animals, professions, and exciting vocabulary!',
                'progress' => 50,
                'completed_topics' => 2,
                'total_topics' => 4,
                'topics' => [
                    [
                        'id' => 'telling-time',
                        'title' => 'Telling Time & Daily Routines',
                        'duration' => '3 Menit',
                        'difficulty' => 'Mudah',
                        'video_title' => 'Fun Clock: Half Past, Quarter To & O\'clock',
                        'video_desc' => 'Listen and learn how native speakers say time easily with friendly songs.',
                        'video_url' => 'https://www.youtube.com/watch?v=ub62gxTuGYU',
                        'micro_steps' => [
                            ['title' => 'O\'clock (Tepat)', 'content' => 'Gunakan "o\'clock" ketika jarum panjang menunjuk tepat ke angka 12. Example: 07.00 is "It is seven o\'clock".', 'highlight' => 'It is seven o\'clock in the morning.'],
                            ['title' => 'Past (Lebih) & To (Kurang)', 'content' => 'Lewat 15 menit = "a quarter past". Lewat 30 menit = "half past". Kurang 15 menit = "a quarter to".', 'highlight' => '08.15 = A quarter past eight | 08.30 = Half past eight'],
                            ['title' => 'Daily Routine Verbs', 'content' => 'Wake up (bangun), take a bath (mandi), have breakfast (sarapan), go to school (pergi ke sekolah).', 'highlight' => 'I always wake up at six o\'clock every day.']
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'How do you say "Pukul 09.00 tepat" in English?',
                                'options' => ['It is nine o\'clock', 'It is half past nine', 'It is nine thirty', 'It is a quarter to nine'],
                                'answer' => 0,
                                'explanation' => 'Awesome! "Nine o\'clock" berarti tepat jam sembilan.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => '"It is a quarter past seven." What time is shown on the clock?',
                                'options' => ['07.15', '07.30', '07.45', '06.45'],
                                'answer' => 0,
                                'explanation' => 'Correct! "A quarter past" artinya lewat seperempat (15 menit). So 07.15!'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Complete the sentence: "Budi usually ... to bed at nine o\'clock in the evening."',
                                'options' => ['goes', 'go', 'going', 'went'],
                                'answer' => 0,
                                'explanation' => 'Brilliant! Karena subjeknya adalah orang ketiga tunggal (Budi/He) dalam Simple Present Tense, kata kerja "go" ditambah akhiran -es menjadi "goes".'
                            ]
                        ]
                    ]
                ]
            ],
            'coding' => [
                'id' => 'coding',
                'name' => 'Coding Dasar & Logika Komputer',
                'class' => 'Kelas 4 - 6',
                'icon' => '💻',
                'color' => '#06b6d4',
                'bg_gradient' => 'linear-gradient(135deg, #0e7490, #06b6d4)',
                'summary' => 'Belajar algoritma robot, blok visual Scratch, perulangan (looping), dan percabangan If-Else yang seru dan mudah dipahami anak!',
                'progress' => 65,
                'completed_topics' => 2,
                'total_topics' => 3,
                'topics' => [
                    [
                        'id' => 'algoritma-robot',
                        'title' => 'Algoritma: Perintah Langkah demi Langkah',
                        'duration' => '3 Menit',
                        'difficulty' => 'Mudah',
                        'video_title' => 'Animasi: Memandu Robot Doni Menuju Bintang',
                        'video_desc' => 'Lihat bagaimana komputer mengeksekusi instruksi berurutan (Maju, Belok, Lompat). Satu langkah salah, robot bisa menabrak tembok!',
                        'video_url' => 'https://www.youtube.com/watch?v=Da5TOXZw4jw',
                        'micro_steps' => [
                            [
                                'title' => 'Apa itu Algoritma?',
                                'content' => 'Algoritma adalah <b>urutan langkah-langkah logis</b> yang disusun secara teratur untuk menyelesaikan suatu masalah atau mencapai tujuan. Contoh nyata: resep membuat kue atau urutan memakai seragam sekolah.',
                                'highlight' => 'Komputer butuh instruksi runtut: Langkah 1 → Langkah 2 → Langkah 3.'
                            ],
                            [
                                'title' => 'Urutan Sangat Menentukan (Sequence)',
                                'content' => 'Komputer menjalankan perintah dari atas ke bawah. Jika urutannya tertukar, hasilnya akan keliru. Contoh: "Buka payung baru keluar rumah", bukan "Keluar rumah dulu baru buka payung".',
                                'highlight' => 'Sequence: Jalankan kode berurutan tanpa melompat.'
                            ],
                            [
                                'title' => 'Bug dan Debugging',
                                'content' => 'Ketika ada kesalahan pada kode yang membuat robot salah arah, kesalahan itu disebut <b>Bug</b> (kutu). Menemukan dan memperbaiki kesalahan tersebut dinamakan <b>Debugging</b>.',
                                'highlight' => 'Programmer hebat tidak takut salah; mereka gemar melakukan debugging!'
                            ]
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Urutan langkah-langkah logis dan teratur untuk menyelesaikan suatu masalah pada komputer disebut...',
                                'options' => ['Algoritma', 'Internet', 'Monitor', 'Baterai'],
                                'answer' => 0,
                                'explanation' => 'Tepat sekali! Algoritma adalah urutan langkah logis demi langkah untuk menyelesaikan tugas.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Robot Doni berada di depan rintangan. Urutan yang benar adalah: (1) Maju 2 petak, (2) Belok kanan, (3) Lompat pagar. Jika langkah (2) dilewati, apa yang terjadi?',
                                'options' => [
                                    'Robot langsung sampai tujuan',
                                    'Robot salah arah dan menabrak tembok di depannya',
                                    'Robot otomatis terbang',
                                    'Baterai robot langsung penuh'
                                ],
                                'answer' => 1,
                                'explanation' => 'Benar! Dalam urutan (sequence), setiap instruksi harus dijalankan tanpa ada yang terlewat agar robot tidak tersesat.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Siti membuat game animasi tetapi karakternya terjebak dan tidak bisa berjalan. Proses mencari dan memperbaiki kesalahan pada kode tersebut disebut...',
                                'options' => ['Debugging', 'Downloading', 'Browsing', 'Formatting'],
                                'answer' => 0,
                                'explanation' => 'Luar biasa! Debugging berasal dari kata "bug" (kutu/kesalahan), yaitu proses melacak dan memperbaiki kesalahan kode program.'
                            ]
                        ]
                    ],
                    [
                        'id' => 'looping-perulangan',
                        'title' => 'Looping: Mengulang Kode Tanpa Capek',
                        'duration' => '4 Menit',
                        'difficulty' => 'Sedang',
                        'video_title' => 'Trik Cepat: Menggambar Bentuk dengan Blok Ulangi',
                        'video_desc' => 'Bandingkan menulis "Maju 1 Langkah" sebanyak 100 baris vs hanya menulis satu blok "Ulangi 100 Kali". Ringkas dan hemat tenaga!',
                        'video_url' => 'https://www.youtube.com/watch?v=VIpmkeqJhmQ',
                        'micro_steps' => [
                            [
                                'title' => 'Kekuatan Looping (Perulangan)',
                                'content' => 'Looping adalah instruksi yang memberitahu komputer untuk <b>mengulang serangkaian perintah</b> beberapa kali secara otomatis tanpa kita harus mengetiknya berulang-ulang.',
                                'highlight' => 'Daripada tulis Maju 10 kali, cukup tulis: Ulangi 10x { Maju 1 langkah }!'
                            ],
                            [
                                'title' => 'Perulangan Tertentu vs Selamanya',
                                'content' => 'Ada <b>Repeat (Ulangi N kali)</b> jika kita tahu jumlahnya (misal 4 kali putaran), dan ada <b>Forever (Selamanya)</b> yang berjalan tanpa henti sampai tombol berhenti ditekan (seperti musik latar game).',
                                'highlight' => 'Blok "Forever" menjaga karakter terus bergerak selama game berjalan.'
                            ],
                            [
                                'title' => 'Visual Block Programming (Scratch)',
                                'content' => 'Untuk anak-anak, coding tidak harus mengetik teks rumit! Kita menyusun balok warna-warni seperti balok LEGO. Blok warna oranye biasanya mengatur kontrol looping.',
                                'highlight' => 'Menyusun balok kode melatih daya logika dan kreativitas berpikir.'
                            ]
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Perintah coding untuk mengulang instruksi yang sama berkali-kali secara otomatis adalah...',
                                'options' => ['Looping (Perulangan)', 'Stopping', 'Deleting', 'Typing'],
                                'answer' => 0,
                                'explanation' => 'Hebat! Looping membuat komputer mengulang pekerjaan secara otomatis dan efisien.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Budi ingin membuat animasi burung yang sayapnya mengepak terus-menerus tanpa henti sepanjang permainan. Blok kontrol apa yang paling cocok?',
                                'options' => [
                                    'Blok Ulangi 1 Kali',
                                    'Blok Selamanya (Forever Loop)',
                                    'Blok Hentikan Semua',
                                    'Blok Hapus Karakter'
                                ],
                                'answer' => 1,
                                'explanation' => 'Tepat! Blok Selamanya (Forever) akan menjalankan animasi sayap mengepak secara terus-menerus.'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Sebuah persegi memiliki 4 sisi sama panjang dan 4 sudut belok 90°. Perintah paling ringkas untuk menggambar persegi adalah...',
                                'options' => [
                                    'Ulangi 4 kali: { Maju 100 langkah, Putar kanan 90 derajat }',
                                    'Maju 400 langkah lurus tanpa belok',
                                    'Ulangi 2 kali: { Maju 100 langkah }',
                                    'Ulangi 90 kali: { Maju 4 langkah }'
                                ],
                                'answer' => 0,
                                'explanation' => 'Brilian! Mengulang (Maju + Putar 90°) sebanyak 4 kali menghasilkan 4 sisi dan 4 sudut persegi yang rapi.'
                            ]
                        ]
                    ],
                    [
                        'id' => 'percabangan-if-else',
                        'title' => 'Kondisi If - Else: Mengambil Keputusan Cerdas',
                        'duration' => '4 Menit',
                        'difficulty' => 'Sedang',
                        'video_title' => 'Karakter Pintar: JIKA Kena Bintang, MAKA Tambah Skor!',
                        'video_desc' => 'Tonton bagaimana karakter game bisa bereaksi cerdas terhadap tombol panah, rintangan duri, dan hadiah koin emas.',
                        'video_url' => 'https://www.youtube.com/watch?v=yYk4_yKj_Y8',
                        'micro_steps' => [
                            [
                                'title' => 'Logika Keputusan (If - Else)',
                                'content' => 'Sama seperti kehidupan nyata: <b>JIKA (If)</b> hujan maka pakai payung, <b>JIKA TIDAK (Else)</b> maka tidak pakai payung. Komputer menggunakan logika ini untuk memilih tindakan.',
                                'highlight' => 'Kondisi menghasilkan nilai Benar (True) atau Salah (False).'
                            ],
                            [
                                'title' => 'Aturan Interaktif di Game',
                                'content' => 'Contoh di game: "JIKA karakter menyentuh koin MAKA koin bertambah 1. JIKA nyawa = 0 MAKA game over". Logika inilah yang membuat game terasa hidup.',
                                'highlight' => 'If - Else mengubah perintah kaku menjadi interaksi dinamis.'
                            ],
                            [
                                'title' => 'Apa itu Variabel?',
                                'content' => '<b>Variabel</b> adalah wadah penyimpan nilai informasi yang bisa berubah-ubah, seperti Jumlah Skor, Sisa Nyawa, atau Level Pemain.',
                                'highlight' => 'Variabel seperti kotak bekal yang isinya bisa kita periksa dan ganti nilainya.'
                            ]
                        ],
                        'exercises' => [
                            [
                                'level' => 'Mudah',
                                'stars' => '★☆☆',
                                'question' => 'Struktur logika yang digunakan untuk membuat komputer memilih aksi berdasarkan kondisi tertentu adalah...',
                                'options' => ['If - Else (Percabangan)', 'Shutdown', 'Paste', 'Copy'],
                                'answer' => 0,
                                'explanation' => 'Benar sekali! Percabangan If - Else membuat komputer mampu mengambil keputusan.'
                            ],
                            [
                                'level' => 'Sedang',
                                'stars' => '★★☆',
                                'question' => 'Perhatikan aturan game: "JIKA skor pemain mencapai 100 MAKA tampilkan piala emas". Kapan piala emas akan muncul di layar?',
                                'options' => [
                                    'Hanya ketika skor pemain minimal bernilai 100',
                                    'Saat skor masih 0',
                                    'Saat pemain baru membuka game',
                                    'Kapan saja secara acak'
                                ],
                                'answer' => 0,
                                'explanation' => 'Tepat! Aksi di dalam blok IF hanya dijalankan jika syarat kondisi bernilai Benar (True).'
                            ],
                            [
                                'level' => 'Sulit',
                                'stars' => '★★★',
                                'question' => 'Dalam game Doni, ada Variabel Koin = 15. Kode program tertulis: "JIKA Koin >= 20 MAKA Beli Pedang Sakti, JIKA TIDAK (Else) Munculkan Pesan: Koinmu Kurang". Apa yang muncul?',
                                'options' => [
                                    'Pesan: Koinmu Kurang',
                                    'Pedang Sakti otomatis dibeli',
                                    'Game langsung tamat',
                                    'Koin Doni berubah jadi 100'
                                ],
                                'answer' => 0,
                                'explanation' => 'Luar biasa! Karena 15 tidak lebih besar atau sama dengan 20, kondisi IF tidak terpenuhi, sehingga blok ELSE (Koinmu Kurang) yang dijalankan.'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Get Daily Quiz Questions
     */
    public static function getDailyQuizQuestions()
    {
        return [
            [
                'subject' => 'Matematika',
                'badge_color' => '#3b82f6',
                'question' => 'Berapakah hasil dari 1/2 + 1/4 ?',
                'options' => ['2/6', '3/4', '2/4', '1/6'],
                'answer' => 1,
                'explanation' => 'Samakan penyebut: 1/2 = 2/4. Maka 2/4 + 1/4 = 3/4.'
            ],
            [
                'subject' => 'IPA',
                'badge_color' => '#10b981',
                'question' => 'Proses fotosintesis pada tumbuhan hijau menghasilkan zat makanan dan gas...',
                'options' => ['Oksigen (O2)', 'Karbon Dioksida (CO2)', 'Nitrogen', 'Metana'],
                'answer' => 0,
                'explanation' => 'Fotosintesis menghasilkan glukosa sebagai energi dan melepaskan gas oksigen yang kita hirup!'
            ],
            [
                'subject' => 'Bahasa Indonesia',
                'badge_color' => '#ef4444',
                'question' => 'Lawan kata (antonim) dari kata "RAJIN" adalah...',
                'options' => ['Pandai', 'Malas', 'Tekun', 'Hemat'],
                'answer' => 1,
                'explanation' => 'Lawan kata dari rajin adalah malas.'
            ],
            [
                'subject' => 'IPS',
                'badge_color' => '#f59e0b',
                'question' => 'Ibu kota provinsi Jawa Barat adalah...',
                'options' => ['Semarang', 'Surabaya', 'Bandung', 'Medan'],
                'answer' => 2,
                'explanation' => 'Bandung adalah ibu kota dari provinsi Jawa Barat.'
            ],
            [
                'subject' => 'Bahasa Inggris',
                'badge_color' => '#8b5cf6',
                'question' => 'What is the opposite of the adjective "BIG"?',
                'options' => ['Fast', 'Small', 'Tall', 'Heavy'],
                'answer' => 1,
                'explanation' => '"Small" means kecil, which is the exact opposite of "Big" (besar).'
            ],
            [
                'subject' => 'Matematika',
                'badge_color' => '#3b82f6',
                'question' => 'FPB (Faktor Persekutuan Terbesar) dari 12 dan 18 adalah...',
                'options' => ['2', '3', '6', '12'],
                'answer' => 2,
                'explanation' => 'Faktor 12: 1, 2, 3, 4, 6, 12. Faktor 18: 1, 2, 3, 6, 9, 18. Faktor terbesar yang sama adalah 6.'
            ],
            [
                'subject' => 'IPA',
                'badge_color' => '#10b981',
                'question' => 'Hewan yang mengalami metamorfosis sempurna adalah...',
                'options' => ['Kupu-kupu', 'Kecoa', 'Belalang', 'Ayam'],
                'answer' => 0,
                'explanation' => 'Kupu-kupu mengalami 4 tahap lengkap: Telur → Ulat (Larva) → Kepompong (Pupa) → Kupu-kupu dewasa.'
            ],
            [
                'subject' => 'IPS',
                'badge_color' => '#f59e0b',
                'question' => 'Candi Borobudur yang megah terletak di provinsi...',
                'options' => ['Jawa Timur', 'Jawa Tengah', 'Bali', 'DI Yogyakarta'],
                'answer' => 1,
                'explanation' => 'Candi Borobudur terletak di Kabupaten Magelang, Provinsi Jawa Tengah.'
            ],
            [
                'subject' => 'Bahasa Indonesia',
                'badge_color' => '#ef4444',
                'question' => 'Kalimat yang menggunakan tanda baca koma (,) yang tepat adalah...',
                'options' => [
                    'Ibu membeli apel, jeruk, dan mangga.',
                    'Ibu membeli, apel jeruk dan mangga.',
                    'Ibu membeli apel jeruk, dan, mangga.',
                    'Ibu membeli apel jeruk dan mangga,'
                ],
                'answer' => 0,
                'explanation' => 'Tanda koma digunakan di antara unsur-unsur dalam perincian atau pembilangan.'
            ],
            [
                'subject' => 'Bahasa Inggris',
                'badge_color' => '#8b5cf6',
                'question' => '"An elephant is very large." The word "elephant" in Indonesian is...',
                'options' => ['Jerapah', 'Gajah', 'Harimau', 'Badak'],
                'answer' => 1,
                'explanation' => 'Elephant artinya Gajah.'
            ],
            [
                'subject' => 'Coding',
                'badge_color' => '#06b6d4',
                'question' => 'Dalam pemrograman komputer, susunan urutan langkah-langkah logis untuk menyelesaikan suatu perintah disebut...',
                'options' => ['Algoritma', 'Kabel data', 'Monitor', 'Baterai'],
                'answer' => 0,
                'explanation' => 'Algoritma adalah susunan langkah demi langkah yang teratur dan logis untuk menyelesaikan tugas dalam komputer.'
            ],
            [
                'subject' => 'Coding',
                'badge_color' => '#06b6d4',
                'question' => 'Blok perintah pada pemrograman visual (Scratch) yang berfungsi untuk mengulang suatu aksi berkali-kali secara otomatis adalah...',
                'options' => ['Looping (Perulangan)', 'Restart', 'Shutdown', 'Hapus'],
                'answer' => 0,
                'explanation' => 'Looping adalah instruksi perulangan yang membuat komputer mengulang perintah tanpa harus menulis kode berulang kali.'
            ]
        ];
    }

    /**
     * Landing Page
     */
    public function index()
    {
        $subjects = Subject::with('topics')->get();
        if ($subjects->isEmpty()) {
            $subjects = self::getSubjectsData();
        }

        $student = Student::where('is_me', true)->first();
        return view('welcome', compact('subjects', 'student'));
    }

    /**
     * Learning Directory
     */
    public function learning()
    {
        $subjects = Subject::with('topics')->get();
        if ($subjects->isEmpty()) {
            $subjects = self::getSubjectsData();
        }
        return view('learning.index', compact('subjects'));
    }

    /**
     * Subject Detail View
     */
    public function subjectDetail($id)
    {
        $subject = Subject::with(['topics.questions'])->find($id);
        
        // If not in DB, use static fallback
        if (!$subject) {
            $subjectsData = self::getSubjectsData();
            if (!isset($subjectsData[$id])) {
                abort(404, 'Mata pelajaran tidak ditemukan.');
            }
            $subject = $subjectsData[$id];
        } else {
            $subjectArray = $subject->toArray();
            $subjectArray['completed_topics'] = 6;
            $subjectArray['total_topics'] = count($subjectArray['topics']) ?: 8;
            foreach ($subjectArray['topics'] as &$top) {
                $top['exercises'] = $top['questions'] ?? [];
            }
            unset($top);
            $subject = $subjectArray;
        }

        // Guarantee embed_url is set for every topic
        foreach ($subject['topics'] as &$top) {
            if (empty($top['embed_url']) && !empty($top['video_url'])) {
                $top['embed_url'] = Topic::parseYoutubeUrl($top['video_url']);
            }
        }
        unset($top);

        $allSubjects = Subject::select('id', 'name', 'icon')->get();
        if ($allSubjects->isEmpty()) {
            $allSubjects = collect(self::getSubjectsData())->map(function ($s) {
                return (object)['id' => $s['id'], 'name' => $s['name'], 'icon' => $s['icon']];
            });
        }

        return view('learning.subject', compact('subject', 'allSubjects'));
    }

    /**
     * Daily 10-Question Streak Quiz
     */
    public function dailyQuiz()
    {
        $dbQuestions = Question::where('is_daily', true)->get();
        if ($dbQuestions->isNotEmpty()) {
            $questions = $dbQuestions->map(function ($q) {
                return [
                    'subject' => ucfirst($q->subject_id),
                    'badge_color' => '#3b82f6',
                    'question' => $q->question,
                    'options' => $q->options,
                    'answer' => $q->answer,
                    'explanation' => $q->explanation
                ];
            })->toArray();
        } else {
            $questions = self::getDailyQuizQuestions();
        }

        return view('quiz.daily', compact('questions'));
    }

    /**
     * Gamification Center: Avatar, Badges, Leaderboard & Mini Games
     */
    public function gamification()
    {
        $badges = Badge::all();
        if ($badges->isEmpty()) {
            $badges = [
                ['id' => 'first-step', 'title' => 'Langkah Pertama', 'icon' => '🚀', 'desc' => 'Menyelesaikan modul pertama', 'unlocked' => true, 'unlocked_at' => 'Kemarin'],
                ['id' => 'quiz-master', 'title' => 'Raja Kuis', 'icon' => '🎯', 'desc' => 'Mendapatkan nilai 100 di kuis harian', 'unlocked' => true, 'unlocked_at' => 'Hari ini'],
                ['id' => 'streak-7', 'title' => 'Api Membara 🔥', 'icon' => '🔥', 'desc' => 'Streak belajar 7 hari berturut-turut', 'unlocked' => true, 'unlocked_at' => '3 hari lalu'],
                ['id' => 'math-wizard', 'title' => 'Penyihir Angka', 'icon' => '📐', 'desc' => 'Selesaikan semua latihan pecahan', 'unlocked' => true, 'unlocked_at' => 'Minggu lalu'],
                ['id' => 'science-detective', 'title' => 'Detektif Sains', 'icon' => '🔬', 'desc' => 'Paham sistem pencernaan & ekosistem', 'unlocked' => false, 'unlocked_at' => null],
                ['id' => 'speed-runner', 'title' => 'Kilat Petir', 'icon' => '⚡', 'desc' => 'Jawab 10 soal math speed dalam 30 detik', 'unlocked' => false, 'unlocked_at' => null],
                ['id' => 'vocabulary-hero', 'title' => 'Jago Bahasa', 'icon' => '📖', 'desc' => 'Temukan 10 ide pokok paragraf', 'unlocked' => false, 'unlocked_at' => null],
                ['id' => 'night-owl', 'title' => 'Bintang Malam', 'icon' => '🌟', 'desc' => 'Belajar sebelum jam 8 malam', 'unlocked' => true, 'unlocked_at' => 'Kemarin']
            ];
        }

        $students = Student::orderByDesc('xp')->get();
        if ($students->isNotEmpty()) {
            $leaderboard = $students->map(function ($s, $idx) {
                return [
                    'rank' => $idx + 1,
                    'name' => $s->name,
                    'xp' => $s->xp,
                    'level' => $s->level,
                    'streak' => $s->streak,
                    'avatar' => $s->avatar,
                    'badge' => 'Ksatria SDS',
                    'is_me' => $s->is_me
                ];
            })->toArray();
        } else {
            $leaderboard = [
                ['rank' => 1, 'name' => 'Ahmad Fauzi', 'xp' => 1420, 'level' => 5, 'streak' => 12, 'avatar' => '🦁', 'badge' => 'Juara Kelas'],
                ['rank' => 2, 'name' => 'Siti Aisyah', 'xp' => 1280, 'level' => 4, 'streak' => 9, 'avatar' => '🦊', 'badge' => 'Bintang Sains'],
                ['rank' => 3, 'name' => 'Doni Pratama (Kamu)', 'xp' => 850, 'level' => 3, 'streak' => 7, 'avatar' => '🚀', 'badge' => 'Ksatria Pintar', 'is_me' => true],
                ['rank' => 4, 'name' => 'Rina Wijaya', 'xp' => 790, 'level' => 3, 'streak' => 6, 'avatar' => '🐱', 'badge' => 'Rajin Belajar'],
                ['rank' => 5, 'name' => 'Budi Santoso', 'xp' => 640, 'level' => 2, 'streak' => 4, 'avatar' => '🐼', 'badge' => 'Penjelajah'],
                ['rank' => 6, 'name' => 'Nadia Safira', 'xp' => 590, 'level' => 2, 'streak' => 3, 'avatar' => '🦄', 'badge' => 'Kreatif']
            ];
        }

        return view('gamification.index', compact('badges', 'leaderboard'));
    }

    /**
     * Teacher Dashboard
     */
    public function teacher()
    {
        $students = Student::all();
        $studentUsers = User::where('role', 'siswa')->get()->keyBy(function($item) {
            return strtolower(trim($item->name));
        });

        // Also map user by stripping (Siswa) if present, e.g. "Doni Pratama (Siswa)" -> "Doni Pratama"
        $studentUsersByCleanName = User::where('role', 'siswa')->get()->keyBy(function($item) {
            $clean = trim(str_replace('(Siswa)', '', $item->name));
            return strtolower($clean);
        });

        $studentsWithAccount = $students->map(function ($s) use ($studentUsers, $studentUsersByCleanName) {
            $lowerName = strtolower(trim($s->name));
            $user = $studentUsers[$lowerName] ?? $studentUsersByCleanName[$lowerName] ?? null;
            return [
                'id' => $s->id,
                'name' => $s->name,
                'class' => $s->class,
                'score' => $s->score,
                'status' => $s->status,
                'streak' => $s->streak,
                'xp' => $s->xp,
                'coins' => $s->coins,
                'avatar' => $s->avatar,
                'level' => $s->level,
                'weakness' => $s->weakness,
                'user' => $user ? [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone
                ] : null
            ];
        });

        // Also check if any User with role='siswa' is not yet in students table
        $knownNames = $students->pluck('name')->map(function($n){ return strtolower(trim($n)); })->toArray();
        foreach (User::where('role', 'siswa')->get() as $u) {
            $clean = strtolower(trim(str_replace('(Siswa)', '', $u->name)));
            if (!in_array($clean, $knownNames) && !in_array(strtolower(trim($u->name)), $knownNames)) {
                $studentsWithAccount->push([
                    'id' => null,
                    'name' => $u->name,
                    'class' => 'Kelas 5-A',
                    'score' => 85,
                    'status' => 'Aktif',
                    'streak' => 1,
                    'xp' => 100,
                    'coins' => 50,
                    'avatar' => $u->avatar ?: '🚀',
                    'level' => 1,
                    'weakness' => 'Belum ada data',
                    'user' => [
                        'id' => $u->id,
                        'username' => $u->username,
                        'email' => $u->email,
                        'phone' => $u->phone
                    ]
                ]);
            }
        }

        $totalStudents = $studentsWithAccount->count() ?: 28;
        $totalWithAccount = $studentsWithAccount->filter(function($s){ return !empty($s['user']); })->count();
        $avgScore = $studentsWithAccount->count() ? round($studentsWithAccount->avg('score'), 1) : 86.4;

        $classStats = [
            'total_students' => $totalStudents,
            'total_with_account' => $totalWithAccount,
            'avg_score' => $avgScore,
            'active_today' => $studentsWithAccount->where('status', 'Aktif')->count() + $studentsWithAccount->where('status', 'Sangat Aktif')->count() ?: 25,
            'completion_rate' => '91.8%'
        ];

        $difficultTopics = [
            [
                'topic' => 'Matematika: Penjumlahan Pecahan Beda Penyebut',
                'subject' => 'Matematika',
                'difficulty_rate' => '68% Siswa Kesulitan',
                'status' => 'Perlu Remedial',
                'status_type' => 'danger',
                'recommendation' => 'Gunakan alat peraga visual pizza dan video animasi perkalian silang.'
            ],
            [
                'topic' => 'IPA: Rantai Makanan & Jaring-jaring Makanan',
                'subject' => 'IPA',
                'difficulty_rate' => '46% Siswa Keliru di Dekomposer',
                'status' => 'Perlu Review',
                'status_type' => 'warning',
                'recommendation' => 'Tekankan kembali peran jamur & bakteri dalam pembusukan nutrisi tanah.'
            ],
            [
                'topic' => 'B. Inggris: Simple Past Tense Irregular Verbs',
                'subject' => 'Bahasa Inggris',
                'difficulty_rate' => '42% Siswa Tertukar',
                'status' => 'Cukup Baik',
                'status_type' => 'info',
                'recommendation' => 'Ajak siswa bermain kartu kata matching game.'
            ]
        ];

        $announcements = Announcement::all();
        if ($announcements->isEmpty()) {
            $announcements = [
                ['title' => 'Kuis Harian Persiapan PTS', 'date' => 'Senin, 05 Okt', 'desc' => 'Anak-anak hebat, jangan lupa selesaikan kuis harian 10 soal sebelum jam 20.00 malam ya!'],
                ['title' => 'Tugas Pengamatan Sains di Halaman Rumah', 'date' => 'Kamis, 08 Okt', 'desc' => 'Temukan 3 serangga dan tuliskan apa yang mereka makan untuk modul ekosistem.']
            ];
        }

        $students = $studentsWithAccount;

        return view('teacher.index', compact('classStats', 'difficultTopics', 'students', 'announcements'));
    }

    /**
     * Parent Portal
     */
    public function parent()
    {
        $setting = ParentSetting::first();
        $student = Student::where('is_me', true)->first();

        $childProfile = [
            'name' => $setting->child_name ?? 'Doni Pratama',
            'class' => 'Kelas 5-A SDS Madani',
            'wali_kelas' => $setting->wali_kelas ?? 'Ibu Rahmawati, S.Pd.',
            'level' => $student->level ?? 3,
            'xp' => $student->xp ?? 850,
            'streak' => $student->streak ?? 7,
            'study_time_today' => $setting->used_screen_time ?? 25,
            'max_screen_time' => $setting->max_screen_time ?? 45,
        ];

        $subjectProgress = [
            ['subject' => 'Matematika', 'score' => 88, 'status' => 'Sangat Baik', 'color' => '#3b82f6'],
            ['subject' => 'IPA', 'score' => 92, 'status' => 'Luar Biasa', 'color' => '#10b981'],
            ['subject' => 'IPS', 'score' => 85, 'status' => 'Bagus', 'color' => '#f59e0b'],
            ['subject' => 'Bahasa Indonesia', 'score' => 90, 'status' => 'Sangat Baik', 'color' => '#ef4444'],
            ['subject' => 'Bahasa Inggris', 'score' => 80, 'status' => 'Cukup Baik', 'color' => '#8b5cf6'],
            ['subject' => 'Coding & Komputer', 'score' => 95, 'status' => 'Luar Biasa', 'color' => '#06b6d4']
        ];

        $notifications = [
            ['time' => '17.30', 'type' => 'WhatsApp', 'text' => '🔔 Halo Bunda Doni! Doni sudah belajar 25 menit hari ini dan meraih skor 100 pada Latihan IPA!'],
            ['time' => '12.00', 'type' => 'Sistem', 'text' => '🔥 Doni mempertahankan Streak 7 Hari berturut-turut!']
        ];

        return view('parent.index', compact('childProfile', 'subjectProgress', 'notifications'));
    }

    /**
     * POST Action: Store newly created question from teacher
     */
    public function storeQuestion(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'level' => 'required',
            'question' => 'required',
            'options' => 'required|array',
            'answer' => 'required|integer',
        ]);

        $stars = '★☆☆';
        if ($request->level === 'Sedang') $stars = '★★☆';
        if ($request->level === 'Sulit') $stars = '★★★';

        $question = Question::create([
            'subject_id' => strtolower($request->subject_id),
            'topic_id' => null,
            'level' => $request->level,
            'stars' => $stars,
            'question' => $request->question,
            'options' => $request->options,
            'answer' => $request->answer,
            'explanation' => $request->explanation ?? 'Hebat! Jawabanmu benar.',
            'is_daily' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Soal baru berhasil disimpan ke database!',
            'data' => $question
        ]);
    }

    /**
     * POST Action: Store newly created learning topic (materi) from teacher
     */
    public function storeTopic(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|string',
            'title' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'difficulty' => 'nullable|string|max:50',
            'video_title' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:500',
            'video_desc' => 'nullable|string',
            'step_title' => 'nullable|array',
            'step_content' => 'nullable|array',
            'step_highlight' => 'nullable|array',
        ]);

        $subjectId = strtolower($request->subject_id);
        
        // Ensure Subject exists in DB
        $subject = Subject::find($subjectId);
        if (!$subject) {
            $subjectsData = self::getSubjectsData();
            if (isset($subjectsData[$subjectId])) {
                $sData = $subjectsData[$subjectId];
                $subject = Subject::create([
                    'id' => $subjectId,
                    'name' => $sData['name'],
                    'class' => $sData['class'],
                    'icon' => $sData['icon'],
                    'color' => $sData['color'],
                    'bg_gradient' => $sData['bg_gradient'],
                    'summary' => $sData['summary'],
                    'progress' => $sData['progress']
                ]);
            }
        }

        // Generate clean unique ID/slug for topic
        $baseSlug = Str::slug($request->title);
        if (empty($baseSlug)) {
            $baseSlug = 'materi-' . time();
        }
        $slug = $baseSlug;
        $counter = 1;
        while (Topic::where('id', $slug)->exists()) {
            $slug = $baseSlug . '-' . (++$counter);
        }

        // Parse micro steps
        $microSteps = [];
        if ($request->has('step_title') && is_array($request->step_title)) {
            foreach ($request->step_title as $idx => $sTitle) {
                if (!empty(trim($sTitle))) {
                    $microSteps[] = [
                        'title' => trim($sTitle),
                        'content' => $request->step_content[$idx] ?? '',
                        'highlight' => $request->step_highlight[$idx] ?? 'Konsep Kunci'
                    ];
                }
            }
        }

        // If no micro steps provided, provide at least one default card
        if (empty($microSteps)) {
            $microSteps = [
                [
                    'title' => 'Ringkasan Materi: ' . $request->title,
                    'content' => $request->video_desc ?: 'Materi pembelajaran mandiri kelas 4 - 6 SDS Madani.',
                    'highlight' => 'Pelajari dengan saksama dan catat poin-poin pentingnya.'
                ]
            ];
        }

        $topic = Topic::create([
            'id' => $slug,
            'subject_id' => $subjectId,
            'title' => $request->title,
            'duration' => $request->duration ?: '3 Menit',
            'difficulty' => $request->difficulty ?: 'Mudah',
            'video_title' => $request->video_title ?: ('Video: ' . $request->title),
            'video_desc' => $request->video_desc ?: 'Simak penjelasan konsep materi secara audio-visual melalui video YouTube ini.',
            'video_url' => $request->video_url ?: null,
            'micro_steps' => $microSteps
        ]);

        // Optional: If teacher also added an exercise question
        if ($request->filled('exercise_question')) {
            $options = [
                $request->exercise_opt_a ?: 'Pilihan A',
                $request->exercise_opt_b ?: 'Pilihan B',
                $request->exercise_opt_c ?: 'Pilihan C',
                $request->exercise_opt_d ?: 'Pilihan D'
            ];
            Question::create([
                'subject_id' => $subjectId,
                'topic_id' => $slug,
                'level' => $request->difficulty ?: 'Mudah',
                'stars' => ($request->difficulty === 'Sulit') ? '★★★' : (($request->difficulty === 'Sedang') ? '★★☆' : '★☆☆'),
                'question' => $request->exercise_question,
                'options' => $options,
                'answer' => (int) ($request->exercise_answer ?? 0),
                'explanation' => $request->exercise_explanation ?: 'Kerja bagus! Jawabanmu tepat sekali.',
                'is_daily' => false
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Materi baru dan link video berhasil disimpan!',
                'topic_id' => $slug,
                'redirect_url' => route('learning.subject', ['id' => $subjectId, 'topic' => $slug])
            ]);
        }

        return redirect()->route('learning.subject', ['id' => $subjectId, 'topic' => $slug])
            ->with('success', 'Materi baru "' . $request->title . '" dan link video YouTube berhasil ditambahkan!');
    }

    /**
     * POST Action: Update YouTube video link for an existing topic
     */
    public function updateTopicVideo(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|string',
            'video_url' => 'nullable|string|max:500',
            'video_title' => 'nullable|string|max:255',
            'video_desc' => 'nullable|string',
        ]);

        $topic = Topic::find($request->topic_id);
        if (!$topic) {
            // Check if it's in seed fallback and needs to be created in DB
            $subjectsData = self::getSubjectsData();
            foreach ($subjectsData as $sId => $sData) {
                foreach ($sData['topics'] as $tData) {
                    if ($tData['id'] === $request->topic_id) {
                        $topic = Topic::create([
                            'id' => $tData['id'],
                            'subject_id' => $sId,
                            'title' => $tData['title'],
                            'duration' => $tData['duration'],
                            'difficulty' => $tData['difficulty'],
                            'video_title' => $tData['video_title'],
                            'video_desc' => $tData['video_desc'],
                            'video_url' => $request->video_url,
                            'micro_steps' => $tData['micro_steps']
                        ]);
                        break 2;
                    }
                }
            }
        }

        if ($topic) {
            if ($request->has('video_url')) {
                $topic->video_url = $request->video_url;
            }
            if ($request->filled('video_title')) {
                $topic->video_title = $request->video_title;
            }
            if ($request->filled('video_desc')) {
                $topic->video_desc = $request->video_desc;
            }
            $topic->save();

            $embedUrl = Topic::parseYoutubeUrl($topic->video_url);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Link video YouTube berhasil diperbarui!',
                    'video_url' => $topic->video_url,
                    'embed_url' => $embedUrl,
                    'video_title' => $topic->video_title,
                    'video_desc' => $topic->video_desc
                ]);
            }

            return redirect()->back()->with('success', 'Link video YouTube untuk materi ini berhasil diperbarui!');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Materi tidak ditemukan.'], 404);
        }

        return redirect()->back()->with('error', 'Materi tidak ditemukan.');
    }

    /**
     * POST Action: Delete a topic
     */
    public function deleteTopic(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|string',
        ]);

        $topic = Topic::find($request->topic_id);
        if ($topic) {
            $subjectId = $topic->subject_id;
            $topic->questions()->delete();
            $topic->delete();

            return redirect()->route('learning.subject', ['id' => $subjectId])
                ->with('success', 'Materi berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Materi tidak ditemukan.');
    }

    /**
     * POST Action: Save student progress (XP, Coins, Avatar, Streak)
     */
    public function saveProgress(Request $request)
    {
        $student = Student::where('is_me', true)->first();
        if ($student) {
            if ($request->has('xp')) $student->xp = $request->xp;
            if ($request->has('coins')) $student->coins = $request->coins;
            if ($request->has('avatar')) $student->avatar = $request->avatar;
            if ($request->has('streak')) $student->streak = $request->streak;
            $student->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Progres siswa berhasil disimpan!'
        ]);
    }

    /**
     * POST Action: Update Parent Settings
     */
    public function updateParentSettings(Request $request)
    {
        $setting = ParentSetting::firstOrCreate(['id' => 1]);
        if ($request->has('max_screen_time')) $setting->max_screen_time = $request->max_screen_time;
        if ($request->has('used_screen_time')) $setting->used_screen_time = $request->used_screen_time;
        if ($request->has('pin')) $setting->pin = $request->pin;
        if ($request->has('study_time')) $setting->study_time = $request->study_time;
        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan orang tua berhasil diperbarui!'
        ]);
    }

    /**
     * GET Action: Export class grade report as CSV
     */
    public function exportReport()
    {
        $students = Student::all();
        $csvFileName = 'rekap_nilai_kelas_5A_sds_madani.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Nama Siswa', 'Kelas', 'Nilai Rata-rata', 'Status', 'Streak Harian', 'Total XP', 'Kelemahan'];

        $callback = function () use ($students, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($students as $st) {
                fputcsv($file, [
                    $st->name,
                    $st->class,
                    $st->score,
                    $st->status,
                    $st->streak . ' Hari',
                    $st->xp . ' XP',
                    $st->weakness ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * POST Action: Store newly created student account by teacher
     */
    public function storeStudentAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'nullable|string|max:50',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'avatar' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:30',
            'score' => 'nullable|integer|min:0|max:100',
        ]);

        $avatar = $request->avatar ?: '🚀';
        $class = $request->class ?: 'Kelas 5-A';
        $score = $request->filled('score') ? (int) $request->score : 85;

        // 1. Create User authentication record
        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'username' => strtolower($request->username),
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'avatar' => $avatar,
            'phone' => $request->phone,
        ]);

        // 2. Create or update Student record for gamification & grade tracking
        $student = Student::firstOrNew(['name' => $request->name]);
        $student->class = $class;
        $student->score = $score;
        $student->status = 'Aktif';
        $student->streak = $student->streak ?: 1;
        $student->xp = $student->xp ?: 100;
        $student->coins = $student->coins ?: 50;
        $student->avatar = $avatar;
        $student->level = $student->level ?: 1;
        $student->weakness = $student->weakness ?: 'Materi Baru';
        $student->is_me = false;
        $student->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Akun siswa berhasil dibuat! Username: ' . $user->username . ', Password: ' . $request->password,
                'data' => [
                    'user' => $user,
                    'student' => $student
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Akun siswa "' . $user->name . '" berhasil dibuat! Siswa sekarang dapat login menggunakan username: ' . $user->username . ' atau email: ' . $user->email);
    }

    /**
     * POST Action: Reset student password by teacher
     */
    public function resetStudentPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'new_password' => 'required|string|min:6',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->role !== 'siswa') {
            return redirect()->back()->with('error', 'Hanya akun siswa yang dapat di-reset oleh guru.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password siswa ' . $user->name . ' berhasil diubah menjadi: ' . $request->new_password
            ]);
        }

        return redirect()->back()->with('success', 'Password akun siswa "' . $user->name . '" berhasil diperbarui!');
    }

    /**
     * POST Action: Delete student account
     */
    public function deleteStudentAccount(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|integer',
            'student_id' => 'nullable|integer',
        ]);

        $deletedName = '';

        if ($request->filled('user_id')) {
            $user = User::find($request->user_id);
            if ($user && $user->role === 'siswa') {
                $deletedName = $user->name;
                Student::where('name', $user->name)->delete();
                $user->delete();
                return redirect()->back()->with('success', 'Akun siswa "' . $deletedName . '" berhasil dihapus.');
            }
        }

        if ($request->filled('student_id')) {
            $student = Student::find($request->student_id);
            if ($student) {
                $deletedName = $student->name;
                User::where('name', $student->name)->where('role', 'siswa')->delete();
                $student->delete();
                return redirect()->back()->with('success', 'Data siswa "' . $deletedName . '" berhasil dihapus.');
            }
        }

        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }
}
