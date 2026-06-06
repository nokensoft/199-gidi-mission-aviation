<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Donation;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === USERS (updateOrCreate agar aman re-seed) ===
        $admin = User::updateOrCreate(['email' => 'admin@gidimissionaviation.com'], ['name' => 'Administrator', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::updateOrCreate(['email' => 'guest@gidimissionaviation.com'], ['name' => 'Guest User', 'password' => Hash::make('password'), 'role' => 'guest']);

        // === SLIDERS ===
        Slider::updateOrCreate(['sort_order' => 1], ['title' => 'GIDI Mission Aviation', 'subtitle' => 'Selamat datang...', 'description' => 'Merupakan wujud kemandirian Gereja Injili di Indonesia di bidang penerbangan dalam mendukung pelayanan misi Gereja.', 'button_text' => 'Tentang Kami', 'button_link' => '#tentang-kami', 'is_active' => true]);
        Slider::updateOrCreate(['sort_order' => 2], ['title' => 'Penggalangan Dana Untuk Pengadaan Pesawat Misi', 'subtitle' => 'Penggalangan Dana', 'description' => 'GIDI berkomitmen penuh untuk mengadakan armada pesawat terbang mandiri guna mengakselerasi serta menunjang seluruh efektivitas pelayanan misi secara optimal.', 'button_text' => 'Informasi Selengkapnya', 'button_link' => '#penggalangan-dana', 'is_active' => true]);

        // === SERVICES ===
        foreach ([
            ['title' => 'Penginjilan', 'description' => 'Mendukung kerja-kerja Missionaris ke ladang misi (terjemahan alkitab, tenaga guru, tenaga medis, dan pengembangan masyarakat lokal).', 'icon' => 'fa-solid fa-earth-americas', 'color' => 'blue', 'sort_order' => 1],
            ['title' => 'Layanan Gerejawi', 'description' => 'Mendukung pelayanan dan kunjungan pastoral serta program pelayanan Gereja.', 'icon' => 'fa-solid fa-users-rays', 'color' => 'indigo', 'sort_order' => 2],
            ['title' => 'Misi Kemanusiaan', 'description' => 'Evakuasi medis darurat bagi seluruh masyarakat yang membutuhkan pertolongan transportasi udara.', 'icon' => 'fa-solid fa-heart-pulse', 'color' => 'red', 'sort_order' => 3],
            ['title' => 'Distribusi Logistik', 'description' => 'Pengiriman logistik barang dan jasa untuk pelayanan di berbagai daerah.', 'icon' => 'fa-solid fa-box-open', 'color' => 'amber', 'sort_order' => 4],
            ['title' => 'Rekanan Misi', 'description' => 'Saling mendukung antar lembaga penerbangan misi guna menjunjung tinggi nilai-nilai kekristenan.', 'icon' => 'fa-solid fa-handshake', 'color' => 'emerald', 'sort_order' => 5],
        ] as $s) { Service::updateOrCreate(['title' => $s['title']], $s); }

        // === PARTNERS ===
        foreach ([
            ['name' => 'GIDI', 'full_name' => 'Gereja Injili di Indonesia', 'logo' => 'logo-sinode-gidi.png', 'sort_order' => 1],
            ['name' => 'YAPELIN', 'full_name' => 'Yayasan Pelayanan Injili', 'logo' => 'logo-yapelin.png', 'sort_order' => 2],
            ['name' => 'STT GIDI', 'full_name' => 'Sekolah Tinggi Teologi Gereja Injili di Indonesia', 'logo' => 'logo-stt-gidi-small.png', 'sort_order' => 3],
            ['name' => 'STAKIN GIDI', 'full_name' => 'Sekolah Teologi Atas Kejuruan Injili', 'logo' => 'logo-stakin.png', 'sort_order' => 4],
            ['name' => 'OKMC', 'full_name' => 'Otto Kobak Mission Center', 'logo' => 'logo-okmc.jpg', 'sort_order' => 5],
            ['name' => 'YASUMAT', 'full_name' => 'Yayasan Sosial Untuk Masyarakat Terpencil', 'logo' => 'logo-yasumat.jpeg', 'sort_order' => 6],
        ] as $p) { Partner::updateOrCreate(['name' => $p['name']], $p); }

        // === DONATIONS + TESTIMONIALS (terintegrasi) ===
        $donationTestimonials = [
            ['donor' => ['donor_name' => 'Capt. Buce Sub', 'donor_phone' => '081289471246', 'package' => 'level_03', 'commitment_type' => 'paid', 'payment_method' => 'transfer', 'status' => 'confirmed', 'confirmed_at' => now()->subDays(30), 'notes' => 'Dukungan penuh untuk penerbangan misi GIDI.'], 'testimonial' => ['role_title' => 'Ketua Tim Aviasi GIDI', 'content' => 'Waktu, tenaga dan pikiran yang saya sumbangkan hari ini akan bermanfaat bagi generasi yang akan datang. Kami punya tanggung jawab moral untuk berkontribusi dalam pelayanan gereja melalui talenta yang Tuhan kasih kepada kita masing-masing.']],
            ['donor' => ['donor_name' => 'Janzen Faidiban', 'donor_phone' => '081234567890', 'package' => 'level_02', 'commitment_type' => 'paid', 'payment_method' => 'transfer', 'status' => 'confirmed', 'confirmed_at' => now()->subDays(25), 'notes' => 'Mendukung lewat teknologi dan informasi.'], 'testimonial' => ['role_title' => 'Nokensoft.com', 'content' => 'Hadirnya penerbangan misi GIDI akan menjadi jembatan kasih dalam menunjang pelayanan misi di Tanah Papua. Kiranya lewat website dan sistem informasi online dapat meningkatkan layanan informasi dan publikasi pelayanan misi tersebut.']],
            ['donor' => ['donor_name' => 'Natalia Rumbewas', 'donor_phone' => '082198765432', 'package' => 'level_01', 'commitment_type' => 'paid', 'payment_method' => 'cash', 'status' => 'confirmed', 'confirmed_at' => now()->subDays(20), 'notes' => 'Persembahan kasih dari keluarga.'], 'testimonial' => ['role_title' => 'Ibu Rumah Tangga', 'content' => 'Dengan adanya penerbangan misi ini bisa menunjang kebutuhan tranportasi udara khususnya di Papua dalam menunjang pelayanan misi gereja dan menuju kemandirian ekonomi jemaat.']],
            ['donor' => ['donor_name' => 'Demianus Wasage', 'donor_phone' => '081345678901', 'package' => 'level_02', 'commitment_type' => 'pledge', 'payment_method' => 'transfer', 'status' => 'pending', 'notes' => 'Komitmen dukungan dari sektor pariwisata.'], 'testimonial' => ['role_title' => 'Trek-Papua.com', 'content' => 'Adanya penerbangan misi yang dimiliki oleh gereja lokal di Papua, akan menjadi peluang promosi usaha rakyat. Salah satunya seperti usaha di bidang pariwisata.']],
        ];

        // Hapus testimoni lama yang tidak terhubung donasi (dari seed sebelumnya)
        Testimonial::whereNull('donation_id')->whereIn('name', array_column(array_column($donationTestimonials, 'donor'), 'donor_name'))->delete();

        foreach ($donationTestimonials as $dt) {
            $donation = Donation::updateOrCreate(
                ['donor_name' => $dt['donor']['donor_name'], 'donor_phone' => $dt['donor']['donor_phone']],
                array_merge($dt['donor'], ['confirmed_by' => $admin->id])
            );
            Testimonial::updateOrCreate(
                ['donation_id' => $donation->id],
                array_merge($dt['testimonial'], ['name' => $dt['donor']['donor_name'], 'visibility' => 'public', 'is_approved' => true, 'is_featured' => true])
            );
        }

        // === SITE SETTINGS ===
        foreach ([
            'site_name' => 'GIDI Mission Aviation', 'site_tagline' => 'Be The Light',
            'site_description' => 'Serving the people of Papua with aviation, compassion, and the love of Christ.',
            'contact_phone_1' => '0812 8947 1246', 'contact_name_1' => 'Capt. Buce Sub', 'contact_title_1' => 'Ketua Tim Aviasi GIDI',
            'contact_phone_2' => '0811 1628 176', 'contact_name_2' => 'Capt. Yotam Pahabol', 'contact_title_2' => 'Sekretaris Tim Aviasi GIDI',
            'office_address' => 'Jl. PLN No 7 Salatiga Sentani, Kab. Jayapura, Papua.', 'office_email' => 'ptskiavia@gmail.com',
            'bank_name' => 'Mandiri Kcp Sentani', 'bank_account' => '1540 0209 7390 9', 'bank_holder' => 'PT. Sayap Kasih Injili',
            'facebook_url' => '#', 'instagram_url' => 'https://instagram.com/gidimissionaviation', 'youtube_url' => '#',
            'president_name' => 'Pdt. Usman Kobak, S.Th, MA.', 'president_title' => 'Presiden Gereja Injili Di Indonesia (GIDI)',
            'president_quote' => 'Gereja Injili Di Indonesia adalah gereja yang besar di Indonesia. Dari segala sisi kita sudah siap. Dari sisi lapangan terbang GIDI sudah siapkan, juga orang yang bawa pesawat (pilot—Red.). Yang belum disiapkan adalah badan pesawatnya. Sehingga saya sangat yakin bersama dengan 8 Wilayah dan para kader Gereja GIDI, kita bisa membeli pesawat terbang sendiri untuk mendukung Penginjilan.',
            'about_verse' => 'Tetapi kamu akan menerima kuasa, kalau Roh Kudus turun ke atas kamu, dan kamu akan menjadi saksi-Ku di Yerusalem dan di seluruh Yudea dan Samaria dan sampai ke ujung bumi.',
            'about_verse_ref' => 'Kisah Para Rasul 1:8',
            'fundraising_description' => 'Dalam rangka mendukung penuntasan amanat penginjilan—baik di dalam maupun di luar negeri—GIDI berkomitmen penuh untuk mengadakan armada pesawat terbang mandiri guna mengakselerasi serta menunjang seluruh efektivitas pelayanan misi secara optimal.',
            'aircraft_title' => 'Cessna Grand Caravan (C208B)',
            'aircraft_description' => 'Kombinasi antara kondisi geografis ekstrem—lapangan terbang yang pendek, tanah tidak rata, cuaca yang cepat berubah, dan elevasi tinggi—membuat pesawat ini menjadi pilihan utama yang sulit tergantikan.',
        ] as $k => $v) { SiteSetting::set($k, $v); }

        // === CATEGORIES ===
        $categoryMap = [];
        foreach (['Penginjilan', 'Penerbangan Misi', 'Berita Gereja', 'Kemanusiaan', 'Kegiatan'] as $c) {
            $cat = Category::updateOrCreate(['name' => $c], ['slug' => Str::slug($c)]);
            $categoryMap[$c] = $cat->id;
        }

        // === 5 SAMPLE ARTICLES ===
        $articles = [
            ['title' => 'Sejarah Penerbangan Misi di Tanah Papua', 'slug' => 'sejarah-penerbangan-misi-di-tanah-papua', 'excerpt' => 'Mengenal sejarah panjang pelayanan penerbangan misi yang telah menghubungkan daerah-daerah terpencil di Papua sejak puluhan tahun lalu.', 'content' => '<p>Penerbangan misi di Papua memiliki sejarah panjang yang dimulai sejak era 1950-an. Saat itu, organisasi misi internasional mulai menggunakan pesawat kecil untuk menjangkau daerah-daerah pedalaman yang tidak bisa dijangkau melalui jalur darat.</p><p>Gereja Injili di Indonesia (GIDI) sebagai salah satu gereja terbesar di Papua, merasakan kebutuhan mendesak untuk memiliki armada penerbangan sendiri. Dengan luas wilayah pelayanan yang mencakup pegunungan tengah Papua, transportasi udara menjadi satu-satunya cara efektif untuk menjangkau jemaat.</p><p>GIDI Mission Aviation (PT. Sayap Kasih Injili) didirikan sebagai wujud kemandirian gereja dalam bidang penerbangan. Langkah ini menunjukkan komitmen GIDI untuk tidak bergantung pada pihak luar dalam menjalankan misi pelayanannya.</p>', 'categories' => ['Penerbangan Misi', 'Berita Gereja'], 'days_ago' => 5],
            ['title' => 'Mengapa Cessna Grand Caravan Cocok untuk Papua', 'slug' => 'mengapa-cessna-grand-caravan-cocok-untuk-papua', 'excerpt' => 'Cessna Grand Caravan C208B dipilih karena kemampuannya mendarat di landasan pendek dan medan ekstrem khas Papua.', 'content' => '<p>Pemilihan pesawat untuk operasi di Papua bukanlah keputusan yang bisa diambil secara sembarangan. Kondisi geografis Papua yang unik — mulai dari pegunungan tinggi, lembah sempit, hingga cuaca yang berubah drastis — membutuhkan pesawat dengan spesifikasi khusus.</p><p>Cessna Grand Caravan C208B telah terbukti sebagai pesawat STOL (Short Take-Off and Landing) yang andal. Pesawat ini mampu membawa hingga 14 penumpang atau 1.500 kg kargo, dengan kemampuan mendarat di landasan sesingkat 500 meter.</p><p>Mesin turboprop Pratt & Whitney PT6A yang digunakan memberikan keandalan tinggi dan efisiensi bahan bakar yang optimal. Pesawat ini telah dioperasikan oleh berbagai organisasi misi di seluruh dunia, termasuk di Afrika, Amerika Selatan, dan Asia Tenggara.</p>', 'categories' => ['Penerbangan Misi'], 'days_ago' => 10],
            ['title' => 'Laporan Kegiatan Penginjilan di Wilayah Pegunungan Tengah', 'slug' => 'laporan-kegiatan-penginjilan-wilayah-pegunungan-tengah', 'excerpt' => 'Tim penginjilan GIDI berhasil menjangkau beberapa kampung terpencil di pegunungan tengah Papua melalui dukungan transportasi udara.', 'content' => '<p>Pada bulan lalu, tim penginjilan GIDI berhasil mengunjungi lima kampung terpencil di wilayah pegunungan tengah Papua. Kunjungan ini dimungkinkan berkat dukungan transportasi udara yang memperpendek waktu tempuh dari berhari-hari berjalan kaki menjadi hanya beberapa jam penerbangan.</p><p>Selama kunjungan, tim melakukan pelayanan firman, pemeriksaan kesehatan dasar, dan distribusi bahan bacaan rohani dalam bahasa daerah setempat. Masyarakat lokal menyambut dengan antusias dan menyampaikan kebutuhan mereka akan kunjungan rutin.</p><p>Pengalaman ini semakin memperkuat keyakinan bahwa kehadiran armada pesawat misi milik GIDI sendiri akan membawa dampak besar bagi efektivitas pelayanan di daerah-daerah yang sulit dijangkau.</p>', 'categories' => ['Penginjilan', 'Kegiatan'], 'days_ago' => 15],
            ['title' => 'Evakuasi Medis Darurat: Kisah Nyata dari Pedalaman', 'slug' => 'evakuasi-medis-darurat-kisah-nyata-dari-pedalaman', 'excerpt' => 'Cerita nyata bagaimana penerbangan misi menyelamatkan nyawa seorang ibu hamil di daerah terpencil Papua.', 'content' => '<p>Di sebuah kampung terpencil di pedalaman Papua, seorang ibu hamil mengalami komplikasi serius yang membutuhkan penanganan medis segera. Puskesmas terdekat yang memiliki fasilitas memadai berjarak tiga hari perjalanan kaki melewati hutan dan pegunungan.</p><p>Berkat koordinasi cepat dengan tim penerbangan misi, sebuah pesawat kecil berhasil mendarat di lapangan terbang kampung tersebut. Dalam waktu kurang dari satu jam, ibu tersebut sudah tiba di rumah sakit dan mendapatkan pertolongan yang dibutuhkan. Alhamdulillah, baik ibu maupun bayinya selamat.</p><p>Kisah ini adalah salah satu dari banyak contoh mengapa penerbangan misi sangat vital bagi masyarakat Papua. Setiap menit sangat berharga, dan kehadiran pesawat misi bisa menjadi perbedaan antara hidup dan mati.</p>', 'categories' => ['Kemanusiaan', 'Berita Gereja'], 'days_ago' => 20],
            ['title' => 'Program Kemitraan: Bersama Membangun Sayap Kasih', 'slug' => 'program-kemitraan-bersama-membangun-sayap-kasih', 'excerpt' => 'GIDI mengajak seluruh elemen masyarakat untuk bergabung dalam program kemitraan penggalangan dana pesawat misi.', 'content' => '<p>GIDI Mission Aviation membuka kesempatan seluas-luasnya bagi siapa saja yang ingin berpartisipasi dalam program pengadaan pesawat misi. Program kemitraan ini dirancang dengan berbagai pilihan paket yang dapat disesuaikan dengan kemampuan masing-masing donatur.</p><p>Mulai dari paket Sahabat Misi (Rp 500.000) untuk dukungan personal, Sayap Kasih (Rp 5.000.000) untuk kelompok persekutuan, hingga Duta Dirgantara (Rp 10.000.000+) untuk lembaga dan organisasi. Bagi yang ingin memberikan nominal lain, tersedia juga opsi Mitra Sukarela dengan nominal bebas.</p><p>Seluruh dana yang terkumpul dikelola secara transparan dan digunakan sepenuhnya untuk program pengadaan armada pesawat misi Cessna Grand Caravan C208B. Setiap rupiah yang Anda sumbangkan akan menjadi bagian dari sayap kasih yang menghubungkan Papua dengan dunia.</p>', 'categories' => ['Berita Gereja', 'Kegiatan'], 'days_ago' => 3],
        ];

        foreach ($articles as $a) {
            $post = Post::updateOrCreate(
                ['slug' => $a['slug']],
                ['user_id' => $admin->id, 'title' => $a['title'], 'excerpt' => $a['excerpt'], 'content' => $a['content'], 'is_published' => true, 'published_at' => now()->subDays($a['days_ago'])]
            );
            $catIds = array_map(fn($name) => $categoryMap[$name], $a['categories']);
            $post->categories()->syncWithoutDetaching($catIds);
        }

        // === PAGES ===
        Page::updateOrCreate(['slug' => 'kebijakan-privasi'], ['title' => 'Kebijakan Privasi', 'content' => '<h2>Kebijakan Privasi</h2><p>GIDI Mission Aviation menghormati privasi pengunjung website kami. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.</p><h3>Informasi yang Kami Kumpulkan</h3><p>Kami mengumpulkan informasi yang Anda berikan secara sukarela, seperti nama, email, dan nomor telepon saat mengisi formulir donasi.</p><h3>Penggunaan Informasi</h3><p>Informasi yang dikumpulkan digunakan untuk memproses donasi, mengirim konfirmasi, dan berkomunikasi terkait program misi kami.</p><h3>Keamanan Data</h3><p>Kami berkomitmen untuk melindungi informasi pribadi Anda dan menerapkan langkah-langkah keamanan yang sesuai.</p>']);
        Page::updateOrCreate(['slug' => 'faq'], ['title' => 'Pertanyaan Umum (FAQ)', 'content' => '<h2>Pertanyaan Umum</h2><h3>Apa itu GIDI Mission Aviation?</h3><p>GIDI Mission Aviation (PT. Sayap Kasih Injili) adalah lembaga penerbangan misi milik Gereja Injili di Indonesia yang bertujuan mendukung pelayanan misi gereja melalui layanan penerbangan.</p><h3>Bagaimana cara berdonasi?</h3><p>Anda dapat berdonasi melalui formulir yang tersedia di website ini atau mentransfer langsung ke rekening resmi PT. Sayap Kasih Injili di Bank Mandiri.</p><h3>Apakah donasi saya aman?</h3><p>Ya, seluruh donasi dikelola secara transparan oleh tim aviasi GIDI dan digunakan sepenuhnya untuk program pengadaan pesawat misi.</p><h3>Pesawat apa yang akan dibeli?</h3><p>Cessna Grand Caravan (C208B), pesawat yang dirancang khusus untuk medan berat seperti Papua dengan landasan pendek dan cuaca ekstrem.</p>']);
        Page::updateOrCreate(['slug' => 'sitemap'], ['title' => 'Peta Situs', 'content' => '<h2>Peta Situs</h2><ul><li><a href="/">Beranda</a></li><li><a href="/blog">Blog</a></li><li><a href="/halaman/kebijakan-privasi">Kebijakan Privasi</a></li><li><a href="/halaman/faq">FAQ</a></li><li><a href="/login">Login Admin</a></li></ul>']);
    }
}
