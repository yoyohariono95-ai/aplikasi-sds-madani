<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Student;
use App\Models\Badge;
use App\Models\Announcement;
use App\Models\ParentSetting;

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

        return view('learning.subject', compact('subject'));
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
        $totalStudents = $students->count() ?: 28;
        $avgScore = $students->count() ? round($students->avg('score'), 1) : 86.4;

        $classStats = [
            'total_students' => $totalStudents,
            'avg_score' => $avgScore,
            'active_today' => $students->where('status', 'Aktif')->count() + $students->where('status', 'Sangat Aktif')->count() ?: 25,
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
            ['subject' => 'Bahasa Inggris', 'score' => 80, 'status' => 'Cukup Baik', 'color' => '#8b5cf6']
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
}
