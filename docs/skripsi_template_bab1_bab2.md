PENGEMBANGAN FULL-STACK E-COMMERCE U-MARKET BERBASIS PROGRESSIVE WEB APP DAN APLIKASI MOBILE MENGGUNAKAN FRAMEWORK LARAVEL, VUE.JS, DAN CAPACITOR DENGAN METODE SCRUM

(Skripsi)

Oleh
[NAMA ANDA]
[NPM ANDA]


PROGRAM STUDI TEKNIK INFORMATIKA
JURUSAN TEKNIK ELEKTRO
FAKULTAS TEKNIK
UNIVERSITAS LAMPUNG
2026




PENGEMBANGAN FULL-STACK E-COMMERCE U-MARKET BERBASIS PROGRESSIVE WEB APP DAN APLIKASI MOBILE MENGGUNAKAN FRAMEWORK LARAVEL, VUE.JS, DAN CAPACITOR DENGAN METODE SCRUM

Oleh
[NAMA ANDA]

Skripsi
Sebagai Salah Satu Syarat untuk Mencapai Gelar
SARJANA TEKNIK

Pada
Jurusan Teknik Elektro
Fakultas Teknik Universitas Lampung


FAKULTAS TEKNIK
UNIVERSITAS LAMPUNG
BANDAR LAMPUNG
2026


ABSTRAK

PENGEMBANGAN FULL-STACK E-COMMERCE U-MARKET BERBASIS PROGRESSIVE WEB APP DAN APLIKASI MOBILE MENGGUNAKAN FRAMEWORK LARAVEL, VUE.JS, DAN CAPACITOR DENGAN METODE SCRUM

Oleh
[NAMA ANDA]

Penelitian ini berfokus pada pengembangan full-stack yang mencakup sisi back-end dan front-end secara terintegrasi, meliputi pengelolaan data pengguna, produk, dan transaksi melalui REST API, serta perancangan antarmuka pengguna yang responsif dan interaktif berbasis Progressive Web App (PWA) dan aplikasi mobile menggunakan Capacitor. Metode Scrum diterapkan untuk mendukung pengembangan sistem secara iteratif melalui 4 tahap sprint, sehingga setiap fitur dapat dikembangkan, diuji, dan dievaluasi secara bertahap. Pengujian sistem dilakukan menggunakan metode black box testing untuk memastikan seluruh fungsi berjalan sesuai kebutuhan, serta stress testing menggunakan Apache JMeter untuk mengukur performa sistem dalam menangani beban pengguna. Hasil pengujian menunjukkan bahwa seluruh fitur yang dikembangkan berjalan dengan baik dan valid sesuai skenario pengujian. Selain itu, berdasarkan hasil stress testing dengan variasi beban hingga 300 sampel pengguna, sistem mampu memberikan respon yang stabil tanpa mengalami kegagalan signifikan. Implementasi fitur utama seperti autentikasi dengan verifikasi email, manajemen produk dengan multi-gambar, keranjang belanja, transaksi dengan integrasi payment gateway Midtrans, pelacakan pesanan real-time berbasis peta, sistem voucher, serta fitur PWA yang mendukung akses offline dan instalasi aplikasi juga berjalan sesuai fungsinya. Dengan demikian, sistem U-Market mampu menjadi solusi e-commerce yang terstruktur, aman, responsif, dan dapat diakses melalui browser maupun sebagai aplikasi mobile, serta penerapan metode Scrum terbukti meningkatkan efektivitas proses pengembangan.

Kata kunci: e-commerce, full-stack, Laravel, Vue.js, Capacitor, PWA, Scrum, U-Market


ABSTRACT

FULL-STACK DEVELOPMENT OF U-MARKET E-COMMERCE BASED ON PROGRESSIVE WEB APP AND MOBILE APPLICATION USING LARAVEL, VUE.JS, AND CAPACITOR FRAMEWORKS WITH THE SCRUM METHOD

By
[NAMA ANDA]

This research focuses on full-stack development encompassing both back-end and front-end integration, including the management of user, product, and transaction data through a structured REST API, as well as the design of a responsive and interactive user interface based on Progressive Web App (PWA) and mobile application using Capacitor. The Scrum method is applied to support iterative and incremental system development through 4 stages of sprints, allowing each feature to be developed, tested, and evaluated progressively. System testing is conducted using black box testing to ensure all functionalities operate as intended, and stress testing using Apache JMeter to evaluate system performance under concurrent user loads. The testing results indicate that all developed features function correctly and meet the defined testing scenarios. Furthermore, stress testing with varying loads of up to 300 samples demonstrates that the system maintains stable performance without significant failures. The implementation of core features, including email-verified authentication, multi-image product management, shopping cart, transaction processing with Midtrans payment gateway integration, real-time map-based order tracking, voucher system, and PWA features supporting offline access and app installation, operates as expected. Therefore, the U-Market system provides a structured, secure, responsive e-commerce solution accessible through both browsers and as a mobile application, while the application of the Scrum method contributes to improving the effectiveness of the development process.

Keyword: e-commerce, full-stack, Laravel, Vue.js, Capacitor, PWA, Scrum, U-Market.


Judul Skripsi       : PENGEMBANGAN FULL-STACK E-COMMERCE
                      U-MARKET BERBASIS PROGRESSIVE WEB APP
                      DAN APLIKASI MOBILE MENGGUNAKAN FRAMEWORK
                      LARAVEL, VUE.JS, DAN CAPACITOR DENGAN
                      METODE SCRUM

Nama Mahasiswa      : [NAMA ANDA]
Nomor Pokok
Mahasiswa           : [NPM ANDA]
Program Studi       : Teknik Informatika
Jurusan             : Teknik Elektro
Fakultas            : Teknik


MENYETUJUI

1. Komisi Pembimbing

Pembimbing Utama                          Pembimbing Pendamping

Yessi Mulyani, S.T., M.T.                ....................................................
NIP. 19731226 200012 2 001                NIP. ........................................


2. Mengetahui

Ketua Jurusan                             Ketua Program Studi
Teknik Elektro                            Teknik Informatika

Herlinawati, S.T., M.T.                  Yessi Mulyani, S.T., M.T.
NIP. 19710314 199903 2 001                NIP. 19731226 200012 2 001


MENGESAHKAN

1. Tim Penguji

Pembimbing 1  : Yessi Mulyani, S.T., M. T.            ......
Pembimbing 2  : ....................................  ......
Penguji       : ....................................  ......

2. Dekan Fakultas Teknik Universitas Lampung

Dr. Hi. Ahmad Herison, S.T., M. T.
NIP. 196910302000031001

Tanggal Lulus Ujian Skripsi: ........... 2026


SURAT PERNYATAAN

Saya yang bertanda tangan di bawah ini, menyatakan bahwa skripsi saya dengan judul "Pengembangan Full-Stack E-Commerce U-Market Berbasis Progressive Web App dan Aplikasi Mobile Menggunakan Framework Laravel, Vue.js, dan Capacitor dengan Metode Scrum" dibuat oleh saya sendiri. Semua hasil yang tertuang pada skripsi ini telah mengikuti kaidah penulisan karya ilmiah Universitas Lampung. Apabila pernyataan saya tidak benar dan terbukti bahwa skripsi ini merupakan salinan atau dibuat oleh orang lain, maka saya bersedia menerima sanksi sesuai dengan ketentuan hukum atau akademik yang berlaku.

Bandar Lampung, ........... 2026
Penulis,

[NAMA ANDA]
NPM. [NPM ANDA]


RIWAYAT HIDUP

[ISI RIWAYAT HIDUP ANDA DI SINI]


PERSEMBAHAN

[ISI PERSEMBAHAN ANDA DI SINI]


MOTTO

[ISI MOTTO ANDA DI SINI]


SANWACANA

Segala puji syukur kehadirat Allah SWT, Tuhan semesta alam yang Maha Pengasih lagi Maha Penyayang, atas limpahan rahmat, taufik serta hidayah-Nya sehingga penulis dapat menyelesaikan penulisan skripsi dengan judul "Pengembangan Full-Stack E-Commerce U-Market Berbasis Progressive Web App dan Aplikasi Mobile Menggunakan Framework Laravel, Vue.js, dan Capacitor dengan Metode Scrum". Sebagai salah satu syarat untuk memperoleh gelar Sarjana Teknik pada Program Studi Teknik Informatika, Jurusan Teknik Elektro, Fakultas Teknik Universitas Lampung. Penulisan skripsi ini tidak lepas dari bantuan, bimbingan, motivasi, dan saran yang diberikan dari semua pihak. Oleh karena itu, pada kesempatan ini penulis ingin mengucapkan terima kasih kepada:

1. Bapak Dr. Hi. Ahmad Herison, S.T., M.T., selaku Dekan Fakultas Teknik Universitas Lampung.
2. Ibu Herlinawati, S.T., M.T., selaku Ketua Jurusan Teknik Elektro Universitas Lampung.
3. Ibu Yessi Mulyani, S.T., M.T., selaku Ketua Program Studi Teknik Informatika sekaligus Dosen Pembimbing Utama yang telah meluangkan waktu, memberikan arahan, bimbingan teknis, ilmu yang bermanfaat, serta motivasi berharga selama penyusunan skripsi ini.
4. ...................................................., selaku Dosen Pembimbing Pendamping yang senantiasa memberikan masukan konstruktif, telaah kritis, dan bimbingan berharga bagi penyempurnaan skripsi ini.
5. ...................................................., selaku Dosen Penguji atas segala saran, koreksi mendalam, dan arahan akademis demi kesempurnaan skripsi ini.
6. Seluruh Dosen dan Staf Pengajar Program Studi S1 Teknik Informatika Universitas Lampung yang telah membagikan ilmu pengetahuan, wawasan teknologi, dan dedikasi selama masa perkuliahan.
7. Kedua orang tua dan keluarga besar tercinta atas limpahan doa yang tak pernah putus, kasih sayang tulus, pengorbanan, serta dukungan moril maupun materiil yang tiada henti.
8. Rekan-rekan mahasiswa Teknik Informatika Universitas Lampung serta semua pihak yang telah memberikan bantuan, semangat, dan kebersamaan yang sangat berharga.

Bandar Lampung, ........... 2026
Penulis,

[NAMA ANDA]
NPM. [NPM ANDA]


================================================================================
DAFTAR ISI
================================================================================

Halaman

DAFTAR ISI........................................................................................................... i
DAFTAR GAMBAR.............................................................................................. ii
DAFTAR TABEL.................................................................................................. iii

I.    PENDAHULUAN .......................................................................................... 1
      1.1  Latar Belakang.......................................................................................... 1
      1.2  Rumusan Masalah .................................................................................... 4
      1.3  Tujuan....................................................................................................... 5
      1.4  Batasan Masalah....................................................................................... 5
      1.5  Manfaat..................................................................................................... 6
      1.6  Sistematika Penulisan Laporan................................................................. 7

II.   TINJAUAN PUSTAKA................................................................................. 9
      2.1  E-commerce.............................................................................................. 9
      2.2  Full-stack Development............................................................................ 9
      2.3  Website .................................................................................................. 11
      2.4  Progressive Web App (PWA)................................................................. 12
      2.5  Aplikasi Mobile Hybrid.......................................................................... 14
      2.6  Capacitor................................................................................................ 15
      2.7  Visual Studio Code................................................................................. 16
      2.8  Unified Modelling Language (UML)...................................................... 17
           2.8.1 Use Case Diagram......................................................................... 17
           2.8.2 Activity Diagram........................................................................... 18
           2.8.3 Class Diagram............................................................................... 18
      2.9  MySQL................................................................................................... 19
      2.10 Framework Laravel ............................................................................... 20
      2.11 Vue.js.................................................................................................... 21
      2.12 Vite........................................................................................................ 22
      2.13 REST API.............................................................................................. 23
      2.14 PHP....................................................................................................... 24
      2.15 JavaScript.............................................................................................. 24
      2.16 Metode Scrum....................................................................................... 25
           2.16.1 Scrum Team................................................................................ 26
           2.16.2 Events Scrum.............................................................................. 28
           2.16.3 Artifacts Scrum........................................................................... 29
      2.17 Black box Testing ................................................................................. 30
      2.18 Postman ................................................................................................ 30
      2.19 Stress Test............................................................................................. 31
      2.20 Apache JMeter...................................................................................... 31
      2.21 Payment Gateway.................................................................................. 32
      2.22 MidTrans............................................................................................... 33
      2.23 Penelitian Terkait.................................................................................. 34

III.  METODOLOGI PENELITIAN.................................................................. xx
IV.   HASIL DAN PEMBAHASAN .................................................................... xx
V.    SIMPULAN DAN SARAN.......................................................................... xx

DAFTAR PUSTAKA........................................................................................ xxx


================================================================================
I. PENDAHULUAN
================================================================================


1.1 Latar Belakang

Perkembangan teknologi informasi yang pesat telah membawa perubahan signifikan dalam berbagai aspek kehidupan manusia, termasuk dalam bidang perdagangan. Salah satu bentuk pemanfaatan teknologi informasi yang paling menonjol saat ini adalah e-commerce, yaitu sistem perdagangan elektronik yang memungkinkan penjual dan pembeli bertransaksi secara daring tanpa batasan ruang dan waktu. Model ini terbukti mampu meningkatkan efisiensi transaksi, memperluas jangkauan pasar, serta mempermudah pengelolaan data penjualan [1].

Di era digital saat ini, aktivitas jual beli tidak hanya dilakukan secara konvensional, tetapi telah beralih ke platform daring yang memungkinkan pelaku usaha maupun individu memasarkan produknya secara lebih luas. Di lingkungan Universitas Lampung, kegiatan jual beli sebelumnya banyak dilakukan melalui grup WhatsApp yang bersifat sementara dan tidak terstruktur. Meskipun praktis, cara ini memiliki berbagai kelemahan seperti informasi penjualan yang mudah tertimbun oleh pesan lain, tidak adanya sistem pencatatan data, serta kurangnya fitur keamanan transaksi [2]. Universitas Lampung memiliki potensi pasar yang besar dengan jumlah mahasiswa mencapai 44.839 orang, yang sebagian besar merupakan pengguna aktif internet dan perangkat digital. Kondisi ini menunjukkan peluang besar bagi terbentuknya ekosistem perdagangan daring yang tidak hanya dimanfaatkan oleh civitas akademika, tetapi juga dapat diakses oleh masyarakat umum.

Berdasarkan permasalahan dan potensi tersebut, sebelumnya telah dikembangkan sebuah website e-commerce bernama U-Market oleh peneliti terdahulu yang berfokus pada pengembangan sisi back-end dan front-end secara terpisah. Namun, pengembangan secara terpisah tersebut menimbulkan beberapa tantangan, antara lain terbatasnya integrasi antar komponen, tidak adanya dukungan akses offline, serta belum tersedianya versi aplikasi mobile yang memungkinkan pengguna mengakses platform tanpa harus membuka browser secara manual.

2

Seiring berkembangnya teknologi web modern, konsep Progressive Web App (PWA) muncul sebagai solusi untuk menjembatani kesenjangan antara aplikasi web dan aplikasi native. PWA memungkinkan aplikasi web untuk diinstal di perangkat pengguna layaknya aplikasi native, mendukung akses offline melalui service worker, serta memberikan pengalaman pengguna yang lebih cepat dan responsif [3]. Selain itu, teknologi Capacitor yang dikembangkan oleh tim Ionic memungkinkan pengembang untuk membungkus aplikasi web berbasis JavaScript modern menjadi aplikasi mobile native yang dapat didistribusikan melalui Google Play Store maupun Apple App Store, tanpa harus menulis ulang kode dari awal [4].

Oleh karena itu, penelitian ini mengembangkan lebih lanjut platform e-commerce U-Market dengan pendekatan full-stack development menggunakan framework Laravel untuk sisi back-end dan Vue.js untuk sisi front-end secara terintegrasi dalam satu codebase. Platform ini dibangun sebagai Progressive Web App (PWA) yang mendukung akses offline dan instalasi langsung di perangkat pengguna, serta dikemas menjadi aplikasi mobile menggunakan Capacitor sehingga menghasilkan file APK yang dapat diinstal di perangkat Android. Selain itu, proses pengembangan sistem dalam penelitian ini menggunakan metode Scrum, yaitu salah satu kerangka kerja Agile yang berfokus pada proses pengembangan iteratif dan inkremental melalui Sprint yang terstruktur. Pendekatan Scrum sangat efektif digunakan dalam pengembangan aplikasi web karena mampu meningkatkan fleksibilitas, mempercepat adaptasi terhadap perubahan kebutuhan, serta memastikan bahwa setiap increment yang dihasilkan dapat langsung diuji dan dievaluasi sebelum melanjutkan ke tahap berikutnya [5]. Dengan mekanisme ini, setiap fitur full-stack seperti autentikasi dengan verifikasi email, manajemen produk dengan multi-gambar, transaksi dengan integrasi Midtrans, pelacakan pesanan berbasis peta, sistem voucher, maupun fitur PWA pada platform e-commerce U-Market dapat dikembangkan secara bertahap, diuji, dan disempurnakan melalui Sprint Review serta retrospective sehingga kualitas sistem dapat terus ditingkatkan selama proses pengembangan berlangsung.

3

Kebaruan dari penelitian ini terletak pada penerapan pendekatan full-stack development yang mengintegrasikan sisi back-end (Laravel) dan front-end (Vue.js) secara terpadu dalam pengembangan e-commerce U-Market, dilengkapi dengan implementasi Progressive Web App (PWA) untuk mendukung pengalaman pengguna yang optimal serta Capacitor untuk menghasilkan aplikasi mobile dari codebase yang sama. Berbeda dengan penelitian sebelumnya yang memisahkan pengembangan back-end dan front-end, penelitian ini menyatukan keduanya dalam satu alur pengembangan sehingga menghasilkan sistem yang lebih kohesif, efisien, dan mudah dimaintain. Penerapan Scrum pada pengembangan full-stack e-commerce komunitas lokal dengan fitur PWA dan mobile app masih relatif jarang dilakukan, khususnya dengan fokus pada pengelolaan sistem secara iteratif dan inkremental melalui pembagian pekerjaan ke dalam beberapa Sprint.

Penelitian ini menitikberatkan pada pengembangan full-stack untuk mengelola data produk, transaksi, dan pengguna secara aman dan efisien melalui back-end Laravel, sekaligus menyajikan antarmuka pengguna yang modern, responsif, dan interaktif melalui front-end Vue.js. Setiap fitur dikembangkan secara bertahap, diuji, dan dievaluasi pada akhir Sprint. Dengan pendekatan tersebut, sistem dapat beradaptasi terhadap perubahan kebutuhan pengguna secara lebih fleksibel dan berkelanjutan. Oleh karena itu, penelitian ini diharapkan mampu memberikan kontribusi nyata dalam mendukung transformasi digital sektor perdagangan lokal sekaligus

4

memperkaya literatur terkait penerapan metode Scrum, framework Laravel, Vue.js, dan teknologi PWA serta Capacitor dalam pengembangan sistem e-commerce modern yang dapat diakses baik melalui web maupun aplikasi mobile.


1.2 Rumusan Masalah

Adapun rumusan masalah dari penelitian ini, yaitu sebagai berikut:

1. Bagaimana mengembangkan full-stack website e-commerce U-Market dengan framework Laravel dan Vue.js agar mampu memfasilitasi aktivitas jual beli secara daring bagi masyarakat umum secara terstruktur, efisien, dan mudah digunakan?

2. Bagaimana mengimplementasikan Progressive Web App (PWA) pada platform U-Market sehingga pengguna dapat mengakses aplikasi secara offline dan menginstalnya langsung di perangkat tanpa melalui app store?

3. Bagaimana mengemas aplikasi web U-Market menjadi aplikasi mobile menggunakan Capacitor sehingga menghasilkan file APK yang dapat diinstal di perangkat Android?

4. Bagaimana menerapkan metode Scrum dalam proses pengembangan sistem agar menghasilkan aplikasi dengan waktu yang relatif cepat dan sesuai dengan kebutuhan pengguna?

5. Bagaimana penerapan fitur-fitur full-stack seperti manajemen produk, autentikasi dengan verifikasi email, pengelolaan transaksi, pelacakan pesanan berbasis peta, dan sistem voucher dalam sistem U-Market?

6. Bagaimana efektivitas sistem U-Market dalam mengatasi masalah penumpukan informasi dan keterbatasan yang terjadi pada media jual beli berbasis grup WhatsApp?


1.3 Tujuan

Adapun tujuan dari penelitian ini diantaranya sebagai berikut:

1. Menghasilkan full-stack website e-commerce U-Market berbasis Progressive Web App yang dapat digunakan oleh masyarakat umum untuk melakukan aktivitas jual beli secara efisien, aman, dan responsif.

2. Mengimplementasikan teknologi Progressive Web App (PWA) dengan service worker dan manifest untuk mendukung akses offline serta instalasi aplikasi langsung di perangkat pengguna.

5

3. Mengemas aplikasi web U-Market menjadi aplikasi mobile Android menggunakan Capacitor dari codebase yang sama, sehingga menghasilkan satu sistem yang dapat diakses melalui web dan mobile.

4. Menerapkan framework Laravel untuk membangun sistem back-end dan Vue.js untuk membangun sistem front-end yang memiliki struktur terorganisasi, mudah dikembangkan, dan memiliki tingkat keamanan yang baik.

5. Mengimplementasikan metode Scrum untuk memastikan bahwa setiap increment yang dihasilkan dapat langsung diuji dan dievaluasi sebelum melanjutkan ke tahap berikutnya.

6. Memberikan solusi terhadap permasalahan jual beli melalui grup WhatsApp dengan menghadirkan platform digital yang lebih terpusat dan terstruktur dengan jangkauan konsumen yang luas.


1.4 Batasan Masalah

Adapun batasan masalah dalam penelitian ini, yaitu sebagai berikut:

1. Penelitian ini berfokus pada pengembangan full-stack website e-commerce U-Market menggunakan framework Laravel untuk back-end dan Vue.js untuk front-end.

2. Implementasi Progressive Web App (PWA) mencakup service worker untuk caching dan akses offline, serta web app manifest untuk instalasi di perangkat.

3. Aplikasi mobile dikembangkan menggunakan Capacitor yang membungkus aplikasi web menjadi APK Android, tanpa pengembangan aplikasi native secara terpisah.

4. Metode pengembangan yang digunakan dalam penelitian ini adalah metode Scrum, yang menekankan pengembangan sistem secara iteratif melalui pembagian pekerjaan ke dalam beberapa Sprint untuk menyesuaikan sistem dengan kebutuhan pengguna.

5. Fitur keamanan yang dikembangkan meliputi autentikasi dengan verifikasi email, enkripsi password, validasi input, serta proteksi CSRF dan middleware, tanpa pembahasan sertifikasi keamanan tingkat lanjut.

6. Fitur pelacakan pesanan berbasis peta menggunakan library Leaflet dengan peta OpenStreetMap.


1.5 Manfaat

Adapun manfaat dari penelitian ini, yaitu sebagai berikut:

1. Menyediakan solusi alternatif bagi masyarakat umum khususnya warga Unila untuk melakukan aktivitas jual beli daring secara lebih terstruktur, efisien, dan aman dibandingkan dengan grup WhatsApp.

6

2. Mempermudah pengelolaan produk dan transaksi dengan sistem berbasis database yang terorganisasi, dilengkapi antarmuka pengguna yang modern dan responsif.

3. Memberikan kemudahan akses bagi pengguna melalui dua platform sekaligus, yaitu melalui browser sebagai Progressive Web App maupun melalui aplikasi mobile yang dapat diinstal langsung di perangkat Android.

4. Memberikan manfaat praktis berupa kemudahan bagi pengguna dalam bertransaksi digital melalui platform U-Market yang terintegrasi, user-friendly, dan mendukung akses offline.

5. Menjadi referensi bagi pengembang dan peneliti lain dalam mengimplementasikan pendekatan full-stack development dengan teknologi PWA dan Capacitor pada sistem e-commerce.


1.6 Sistematika Penulisan Laporan

Laporan ini dibagi menjadi beberapa bab untuk memudahkan dalam penguraian, antara lain:

BAB I    : PENDAHULUAN
           Bab ini memuat latar belakang yang menjelaskan
           alasan pengembangan full-stack U-Market berbasis
           Progressive Web App dan aplikasi mobile, rumusan
           masalah yang ingin diselesaikan, tujuan penelitian,
           batasan masalah, manfaat yang diharapkan dari
           pengembangan ini, serta sistematika penulisan laporan.

BAB II   : TINJAUAN PUSTAKA
           Bab ini memuat teori dasar dalam pengembangan
           U-Market. Pembahasan dalam bab ini meliputi
           e-commerce, Full-stack Development, Website,
           Progressive Web App (PWA), Aplikasi Mobile Hybrid,
           Capacitor, Visual Studio Code, Unified Modelling
           Language (UML), MySQL, Framework Laravel, Vue.js,
           Vite, REST API, PHP, JavaScript, Metode Scrum,
           Blackbox Testing, Postman, Stress Test, Apache
           JMeter, Payment Gateway, MidTrans, dan Penelitian
           Terkait.

BAB III  : METODOLOGI PENELITIAN
           Bab ini membahas metodologi penelitian yang
           digunakan dalam pengembangan U-Market, termasuk
           waktu dan tempat penelitian, perangkat keras dan
           perangkat lunak yang digunakan, serta tahapan
           penelitian yang dilakukan menggunakan metode Scrum.

7

BAB IV   : HASIL DAN PEMBAHASAN
           Bab ini berisi hasil dari pengembangan full-stack
           U-Market berbasis Progressive Web App dan aplikasi
           mobile menggunakan framework Laravel, Vue.js, dan
           Capacitor, serta pembahasan terkait implementasi
           sistem. Pembahasan mencakup desain sistem, hasil
           pengujian fitur back-end dan front-end, integrasi
           PWA dan mobile app, serta analisis sistem dalam
           memenuhi kebutuhan pengguna.

BAB V    : PENUTUP
           Bab ini menyajikan kesimpulan dari penelitian
           yang telah dilakukan terkait pengembangan
           U-Market, serta saran untuk pengembangan lebih
           lanjut yang dapat meningkatkan kinerja dan
           manfaat sistem bagi penggunanya.


================================================================================
II. TINJAUAN PUSTAKA
================================================================================


2.1 E-commerce

E-commerce adalah rangkaian aktivitas bisnis yang memanfaatkan jaringan elektronik untuk melakukan transaksi jual-beli barang dan/atau jasa beserta dukungan proses pendukungnya, seperti pencatatan produk, katalog digital, manajemen pesanan, pembayaran elektronik, logistik, dan layanan purna-jual. E-commerce tidak hanya dipahami sebagai proses transaksi jual beli secara online, tetapi juga mencakup pertukaran informasi, pengelolaan hubungan pelanggan, serta integrasi proses bisnis secara digital. Perkembangan teknologi internet telah mengubah pola perdagangan tradisional menjadi sistem berbasis digital yang lebih efisien dan fleksibel [6]. Dalam arsitektur sistem, e-commerce tidak hanya soal tampilan toko online, melainkan sebuah ekosistem yang menggabungkan fungsi front-end (interaksi pengguna) dan back-end (pemrosesan transaksi, manajemen data, integrasi sistem pembayaran/kurir, keamanan, serta analitik) [7].

Dalam konteks penelitian ini, platform e-commerce U-Market dirancang sebagai sistem full-stack yang mengintegrasikan fungsi front-end dan back-end secara terpadu, sehingga seluruh proses bisnis mulai dari penelusuran produk, pengelolaan keranjang, hingga pembayaran dan pelacakan pesanan dapat berjalan secara kohesif dalam satu ekosistem digital yang terstruktur.


2.2 Full-stack Development

Full-stack development merupakan pendekatan pengembangan aplikasi berbasis web yang mencakup seluruh lapisan sistem, meliputi sisi client (front-end) dan sisi server (back-end), hingga pengelolaan basis data. Seorang pengembang full-stack bertanggung jawab terhadap perancangan antarmuka pengguna yang interaktif dan responsif, sekaligus membangun logika bisnis, pengelolaan data, serta layanan API di sisi server. Menurut Sarmanela, Samiya, dan Yuliana (2023), pengembangan sisi back-end mencakup pengelolaan database, pemrograman server-side, serta integrasi layanan melalui Application Programming Interface (API) yang berfungsi untuk mendukung kebutuhan sistem yang tidak terlihat secara langsung oleh pengguna [8].

10

Dalam pengembangan aplikasi web modern, pendekatan full-stack memberikan keunggulan signifikan dibandingkan pengembangan terpisah antara front-end dan back-end. Dengan pendekatan ini, pengembang memiliki pemahaman menyeluruh terhadap arsitektur sistem sehingga integrasi antar komponen menjadi lebih konsisten, efisien, dan mudah dimaintain. Proses full-stack development melibatkan penerapan mekanisme autentikasi dan otorisasi pengguna di sisi back-end, sekaligus merancang antarmuka yang intuitif di sisi front-end untuk memastikan pengalaman pengguna yang optimal.

Sisi back-end pada pengembangan full-stack berperan penting dalam menjaga stabilitas, keamanan, dan performa sistem. Back-end menangani pemrosesan data, validasi input, manajemen sesi, serta komunikasi dengan basis data. Sementara itu, sisi front-end bertanggung jawab terhadap rendering antarmuka, pengelolaan state aplikasi, navigasi halaman, serta interaksi pengguna secara real-time. Keduanya terhubung melalui REST API yang memungkinkan pertukaran data secara terstruktur dan aman.

Pada sistem e-commerce, pendekatan full-stack memiliki peran strategis dalam mengelola seluruh siklus transaksi mulai dari penelusuran produk oleh pembeli, pengelolaan produk oleh penjual, proses pembayaran, hingga pelacakan pesanan. Dalam penelitian ini, full-stack development diterapkan pada pengembangan sistem e-commerce U-Market dengan memanfaatkan framework Laravel untuk sisi back-end dan Vue.js untuk sisi front-end. Penggunaan Laravel membantu menciptakan struktur API yang terorganisir dan aman, sedangkan Vue.js menyediakan antarmuka pengguna yang reaktif, modular, dan responsif. Kombinasi keduanya, ditambah dengan implementasi Progressive Web App (PWA) dan Capacitor, menghasilkan sistem yang tidak hanya lengkap secara fungsional tetapi juga optimal dari sisi pengalaman pengguna, baik di browser maupun sebagai aplikasi mobile.


2.3 Website

Website atau situs merupakan salah satu komponen paling fundamental dalam era digital saat ini, berfungsi sebagai media penyampaian informasi, sarana komunikasi, dan platform layanan interaktif bagi masyarakat. Sebuah website adalah gabungan dari beberapa halaman yang menampilkan informasi dalam berbagai bentuk seperti teks, gambar, audio, video, animasi, atau kombinasi dari semuanya yang saling terhubung dalam satu struktur dokumen yang dapat diakses melalui World Wide Web melalui alamat domain atau subdomain tertentu. Website memungkinkan konten bersifat dinamis dan interaktif, sekaligus membuka akses informasi secara global selama terhubung dengan internet [9].

11

Halaman-halaman pada website yang saling terhubung ini menjadikan media data yang menarik dan fungsional bagi pengguna. Struktur website yang terdiri atas teks, gambar, suara, dan aktivitas konten lainnya membutuhkan pengelolaan melalui protokol HTTP serta representasi halaman dalam HTML yang dapat ditangani oleh server web. Hal ini menunjukkan bahwa website bukan sekadar dokumen statis, melainkan merupakan himpunan resource yang dapat dikembangkan untuk berbagai tujuan, termasuk penyajian informasi, interaksi pengguna, dan penyediaan layanan informasi bisnis atau edukasi.

Dalam perkembangan teknologi web modern, website telah berevolusi dari sekadar halaman statis menjadi aplikasi web yang kompleks dan interaktif. Kemunculan teknologi Single Page Application (SPA) memungkinkan website berperilaku seperti aplikasi desktop, di mana konten halaman diperbarui secara dinamis tanpa perlu memuat ulang seluruh halaman. Pendekatan ini meningkatkan kecepatan dan responsivitas website secara signifikan, memberikan pengalaman pengguna yang lebih baik.


2.4 Progressive Web App (PWA)

Progressive Web App (PWA) adalah pendekatan pengembangan aplikasi web yang menggabungkan keunggulan aplikasi web tradisional dengan kemampuan yang biasanya hanya dimiliki oleh aplikasi native. PWA memanfaatkan teknologi web modern seperti service worker, web app manifest, dan HTTPS untuk menghadirkan pengalaman pengguna yang reliable, cepat, dan engaging [10]. Konsep PWA pertama kali diperkenalkan oleh Google pada tahun 2015 sebagai jawaban atas kebutuhan akan aplikasi yang dapat berjalan di berbagai platform tanpa memerlukan proses instalasi melalui app store.

Service worker merupakan komponen inti dari PWA yang berperan sebagai proxy antara aplikasi web dan jaringan. Service worker berjalan di latar belakang (background thread) dan memungkinkan aplikasi untuk melakukan caching aset secara otomatis, sehingga konten tetap dapat diakses meskipun perangkat tidak terhubung ke internet (offline mode). Selain itu, service worker juga mendukung fitur push notification dan background sync yang meningkatkan interaktivitas aplikasi [11].

12

Web app manifest adalah file JSON yang mendefinisikan metadata aplikasi, seperti nama, ikon, tema warna, dan orientasi tampilan. Dengan adanya manifest, browser dapat menampilkan prompt instalasi (Add to Home Screen) kepada pengguna, sehingga PWA dapat dipasang di layar utama perangkat layaknya aplikasi native tanpa melalui app store. Setelah diinstal, PWA berjalan dalam mode standalone dengan tampilan fullscreen yang menyerupai aplikasi native [12].

Keunggulan PWA dibandingkan aplikasi native konvensional meliputi: (1) tidak memerlukan proses unduh dari app store sehingga mengurangi hambatan adopsi; (2) ukuran yang jauh lebih kecil dibandingkan aplikasi native; (3) dapat diperbarui secara otomatis tanpa intervensi pengguna; (4) berjalan di berbagai platform (cross-platform) dengan satu codebase; serta (5) dapat diindeks oleh mesin pencari sehingga meningkatkan discoverability. Dalam konteks penelitian ini, implementasi PWA pada platform U-Market bertujuan untuk memberikan pengalaman pengguna yang optimal, mendukung akses offline melalui caching service worker, serta memungkinkan instalasi langsung di perangkat tanpa memerlukan app store.


2.5 Aplikasi Mobile Hybrid

Aplikasi mobile hybrid merupakan pendekatan pengembangan aplikasi mobile yang menggabungkan teknologi web (HTML, CSS, JavaScript) dengan kontainer native untuk menghasilkan aplikasi yang dapat didistribusikan melalui app store. Berbeda dengan aplikasi native yang dikembangkan secara khusus untuk satu platform menggunakan bahasa pemrograman tertentu (seperti Kotlin untuk Android atau Swift untuk iOS), aplikasi hybrid memungkinkan pengembang menggunakan satu codebase untuk menghasilkan aplikasi di berbagai platform sekaligus [13].

Pendekatan hybrid memiliki beberapa keunggulan strategis, diantaranya: (1) efisiensi biaya dan waktu pengembangan karena hanya memerlukan satu codebase; (2) kemudahan pemeliharaan karena perubahan kode berlaku untuk semua platform; (3) akses terhadap fitur native perangkat melalui plugin atau bridge; serta (4) kemampuan untuk memanfaatkan ekosistem dan library JavaScript yang sangat luas. Meskipun demikian, aplikasi hybrid memiliki keterbatasan dalam hal performa untuk operasi yang membutuhkan komputasi intensif, seperti game atau aplikasi realitas virtual [14].

13

Dalam konteks sistem e-commerce, pendekatan hybrid sangat sesuai karena mayoritas fitur yang dibutuhkan -- seperti menampilkan daftar produk, mengelola keranjang, memproses transaksi, dan menampilkan peta -- tidak memerlukan performa grafis yang berat dan dapat ditangani dengan baik oleh teknologi web modern. Dengan demikian, pengembangan aplikasi mobile U-Market menggunakan pendekatan hybrid melalui Capacitor menjadi pilihan yang tepat untuk menghasilkan aplikasi mobile dengan kualitas yang memadai namun dengan effort pengembangan yang efisien.


2.6 Capacitor

Capacitor adalah runtime lintas platform (cross-platform) yang dikembangkan oleh tim Ionic dan bersifat open-source, dirancang untuk memudahkan pengembang dalam membangun aplikasi mobile native menggunakan teknologi web modern seperti HTML, CSS, dan JavaScript. Capacitor berfungsi sebagai bridge antara kode web dan API native perangkat, memungkinkan aplikasi web untuk mengakses fitur-fitur native seperti kamera, GPS, penyimpanan lokal, dan push notification [15].

Cara kerja Capacitor adalah dengan menjalankan aplikasi web di dalam WebView native pada setiap platform (Android dan iOS), kemudian menyediakan lapisan abstraksi (plugin API) yang menghubungkan kode JavaScript dengan fungsi native masing-masing platform. Dengan pendekatan ini, pengembang tidak perlu menulis kode native secara terpisah untuk setiap platform, namun tetap dapat mengakses kemampuan penuh perangkat. Capacitor mendukung berbagai framework JavaScript modern seperti Vue.js, React, dan Angular, sehingga pengembang dapat memanfaatkan framework yang sudah mereka kuasai tanpa perlu mempelajari teknologi baru [16].

14

Keunggulan Capacitor dibandingkan solusi hybrid lainnya seperti Cordova meliputi: (1) arsitektur yang lebih modern dengan dukungan penuh terhadap ES modules dan Web APIs terbaru; (2) kemampuan untuk menambahkan kode native secara langsung ketika dibutuhkan; (3) proses build yang lebih stabil dan terintegrasi dengan Android Studio dan Xcode; serta (4) ekosistem plugin yang terus berkembang.

Dalam penelitian ini, Capacitor digunakan untuk mengemas aplikasi web U-Market yang dibangun dengan Vue.js menjadi aplikasi mobile Android dalam format APK. Proses ini dilakukan tanpa perubahan signifikan pada codebase utama, sehingga satu codebase menghasilkan dua output sekaligus: aplikasi web PWA yang berjalan di browser dan aplikasi mobile yang dapat diinstal di perangkat Android.


2.7 Visual Studio Code

Visual Studio Code merupakan sebuah editor kode sumber yang dikembangkan oleh Microsoft dan telah menjadi salah satu perangkat lunak pengembangan yang banyak digunakan oleh komunitas programmer modern. Dalam penelitian yang dilakukan oleh Hidayah dan Rofiqoh (2024), Visual Studio Code dijelaskan sebagai editor kode yang bersifat open source, ringan, dan mendukung berbagai fitur pengembangan seperti penyorotan sintaksis, penyelesaian kode otomatis, refaktor kode, debugging, serta integrasi dengan sistem kontrol versi seperti Git. Selain itu, antarmuka yang intuitif dan kemampuan penyesuaian melalui extensions membuat Visual Studio Code menjadi alat yang efektif dan efisien digunakan oleh pengembang perangkat lunak, terutama dalam pengembangan aplikasi full-stack yang melibatkan berbagai teknologi seperti PHP, JavaScript, Vue.js, dan HTML/CSS sebagaimana diterapkan dalam penelitian ini [17].

Dalam pengembangan full-stack U-Market, Visual Studio Code digunakan sebagai IDE utama yang dilengkapi dengan berbagai ekstensi pendukung seperti Volar untuk pengembangan Vue.js, Laravel Blade Snippets untuk template Blade Laravel, serta ekstensi PHP dan JavaScript untuk mendukung penulisan kode di kedua sisi pengembangan.

15


2.8 Unified Modelling Language (UML)

Unified Modelling Language (UML) adalah salah satu alat bantu yang sangat handal di dunia pengembangan sistem yang berorientasi obyek. Hal ini disebabkan karena UML menyediakan bahasa pemodelan visual yang memungkinkan bagi pengembang sistem untuk membuat cetak biru atas visi mereka dalam bentuk yang baku, mudah dimengerti serta dilengkapi dengan mekanisme yang efektif untuk berbagi dan mengkomunikasikan rancangan mereka dengan yang lain [18]. UML menyediakan diagram-diagram seperti use case, aktivitas, kelas, sequence, dan lainnya yang memfasilitasi komunikasi antar tim dan mereduksi risiko kesalahpahaman dalam requirement dan desain sistem. UML digunakan untuk merancang model konseptual sistem, termasuk use case diagram untuk memetakan interaksi pengguna dan admin, diagram aktivitas untuk alur transaksi pembelian, serta diagram kelas untuk menggambarkan struktur basis data. Penggunaan UML ini membantu memperjelas kebutuhan sistem e-commerce sebelum proses pengkodean dilakukan.


2.8.1 Use Case Diagram

Use case diagram merupakan bagian dari Unified Modeling Language (UML) yang digunakan untuk memodelkan kebutuhan fungsional sistem berdasarkan interaksi antara aktor dan sistem. Use case diagram membantu mengidentifikasi peran pengguna serta layanan yang disediakan sistem pada tingkat abstraksi yang tinggi sehingga mudah dipahami oleh pengguna maupun pengembang [19]. Dalam perancangan sistem e-commerce, use case diagram digunakan untuk memetakan aktor seperti admin, penjual, pembeli, dan pengunjung beserta hak akses dan fungsinya masing-masing dalam sistem [20]. Dengan pendekatan tersebut, kebutuhan sistem dapat terdokumentasi secara sistematis sejak tahap analisis sehingga meminimalkan miskomunikasi selama proses pengembangan.


2.8.2 Activity Diagram

Activity diagram digunakan untuk menggambarkan alur aktivitas atau proses bisnis yang berlangsung di dalam sistem secara lebih rinci. Activity diagram menunjukkan urutan kegiatan, percabangan keputusan, hingga kondisi awal dan akhir dari suatu proses, sehingga memudahkan analisis terhadap logika kerja sistem sebelum diimplementasikan [19]. Dalam implementasi sistem e-commerce, activity diagram dimanfaatkan untuk memodelkan proses seperti pengelolaan produk oleh penjual, alur pemesanan oleh pembeli, proses verifikasi email, hingga proses checkout dan pembayaran, sehingga setiap tahapan operasional dapat dirancang secara terstruktur [20].

16

Representasi visual ini membantu memastikan bahwa alur sistem baik di sisi back-end maupun front-end telah sesuai dengan kebutuhan bisnis yang direncanakan.


2.8.3 Class Diagram

Class diagram merepresentasikan struktur statis sistem dengan menampilkan kelas, atribut, metode, serta hubungan antar kelas dalam pendekatan berorientasi objek. UML menyediakan class diagram sebagai sarana untuk mendefinisikan arsitektur sistem secara konseptual sebelum tahap implementasi dilakukan [19]. Pada sistem e-commerce U-Market, class diagram memuat entitas seperti User, Profile, Product, ProductImage, Cart, CartItem, Transaction, TransactionItem, Category, Voucher, VoucherUsage, OrderTracking, BankAccount, Withdrawal, dan StoreVisit yang saling berelasi untuk mendukung proses transaksi dan pengelolaan data [20]. Dengan adanya pemodelan ini, struktur sistem menjadi lebih terorganisasi, memudahkan pengembangan, serta mendukung pemeliharaan dan pengembangan lanjutan di masa mendatang.


2.9 MySQL

Database merupakan komponen krusial dalam arsitektur sistem aplikasi e-commerce karena berfungsi sebagai pusat penyimpanan dan pengelolaan seluruh data yang digunakan sistem, seperti informasi produk, data pengguna, keranjang belanja, transaksi, voucher, pelacakan pesanan, serta histori penarikan dana. Menurut Connolly dan Begg [21], database adalah kumpulan data yang saling berhubungan yang disimpan secara sistematis agar dapat diakses dan dikelola secara efisien oleh perangkat lunak. Penggunaan sistem manajemen basis data (DBMS) memungkinkan pengembang untuk menerapkan operasi CRUD (Create, Read, Update, Delete) secara konsisten, serta menjaga integritas dan keamanan data dalam aplikasi.

17

MySQL merupakan salah satu DBMS yang paling umum digunakan dalam pengembangan aplikasi web modern karena bersifat open-source, mendukung bahasa SQL (Structured Query Language), dan memiliki performa tinggi pada transaksi berorientasi data besar. Menurut penelitian oleh Hidayat et al. [22], MySQL memiliki kemampuan optimasi query serta dukungan replikasi data yang baik sehingga mampu menjaga kecepatan dan konsistensi sistem e-commerce berskala menengah hingga besar. Dalam penelitian ini, MySQL digunakan sebagai DBMS utama untuk menyimpan seluruh data sistem U-Market, dengan struktur tabel yang dirancang menggunakan fitur migration pada Laravel untuk memastikan konsistensi skema database.


2.10 Framework Laravel

Laravel adalah framework PHP modern yang mengusung konsep MVC (Model-View-Controller) dan memudahkan pengembangan web dengan fitur seperti routing, ORM, middleware, dan migration [23]. MVC sendiri memiliki tiga bagian. Pertama, model berfungsi sebagai bagian yang menghubungkan aplikasi dengan database. Kedua, view berfungsi sebagai bagian dari desain view di mana Controller dikelola oleh view. Ketiga, controller berfungsi sebagai controller atau pengontrol model dan view sebelum selanjutnya menentukan aplikasi apa yang akan diproses.

Selain menerapkan arsitektur MVC, Laravel juga dilengkapi dengan berbagai fitur canggih yang mempercepat proses pengembangan aplikasi web, seperti Blade Template Engine untuk pengelolaan tampilan dinamis, Eloquent ORM untuk interaksi basis data yang lebih efisien, serta Artisan CLI yang memudahkan otomatisasi tugas-tugas rutin pengembang. Framework ini juga memiliki sistem keamanan yang baik melalui perlindungan Cross-Site Request Forgery (CSRF), Cross-Site Scripting (XSS), dan SQL Injection. Dengan dokumentasi yang lengkap serta dukungan komunitas yang luas, Laravel menjadi salah satu framework PHP paling populer dan andal dalam membangun aplikasi web berskala kecil hingga besar [1].

18

Dalam konteks penelitian ini, Laravel digunakan sebagai fondasi sisi back-end sistem U-Market yang menyediakan REST API untuk komunikasi dengan front-end Vue.js. Laravel juga dimanfaatkan untuk mengelola proses autentikasi berbasis session, verifikasi email, integrasi payment gateway Midtrans, serta pengelolaan file upload produk dan foto profil pengguna.


2.11 Vue.js

Vue.js adalah framework JavaScript progresif yang dirancang untuk membangun antarmuka pengguna (user interface) pada aplikasi web. Dikembangkan oleh Evan You pada tahun 2014, Vue.js mengadopsi arsitektur berbasis komponen (component-based architecture) yang memungkinkan pengembang untuk memecah antarmuka ke dalam komponen-komponen kecil yang dapat digunakan kembali (reusable) [24]. Pendekatan ini meningkatkan modularitas kode, memudahkan pemeliharaan, serta mempercepat proses pengembangan.

Vue.js menggunakan konsep reactivity system yang secara otomatis memperbarui tampilan (view) ketika data (state) berubah, tanpa memerlukan manipulasi DOM secara manual. Fitur ini sangat berguna dalam pengembangan aplikasi web interaktif seperti e-commerce, di mana perubahan data seperti jumlah item di keranjang, status pesanan, atau hasil pencarian produk harus segera tercermin di antarmuka pengguna. Selain itu, Vue.js mendukung Single File Component (SFC) dengan ekstensi .vue yang menggabungkan template HTML, logika JavaScript, dan styling CSS dalam satu file, sehingga memudahkan organisasi kode [25].

19

Ekosistem Vue.js yang kaya mencakup Vue Router untuk pengelolaan navigasi antar halaman (client-side routing), Pinia atau Vuex untuk state management, serta berbagai library pendukung seperti Axios untuk HTTP request. Dalam penelitian ini, Vue.js versi 3 digunakan dengan Composition API sebagai front-end framework untuk membangun antarmuka pengguna U-Market yang responsif dan interaktif. Vue Router digunakan untuk navigasi tanpa reload halaman, serta berbagai komponen Vue seperti keranjang belanja, halaman produk, formulir checkout, dan peta pelacakan pesanan dikembangkan sebagai komponen yang modular dan reusable.


2.12 Vite

Vite adalah build tool generasi baru untuk proyek web modern yang dikembangkan oleh Evan You, kreator Vue.js. Vite memanfaatkan native ES modules pada browser modern untuk menyajikan kode secara instan selama pengembangan, tanpa memerlukan proses bundling yang memakan waktu seperti pada build tool tradisional [26]. Hal ini menghasilkan Hot Module Replacement (HMR) yang sangat cepat, di mana perubahan kode langsung tercermin di browser dalam hitungan milidetik tanpa kehilangan state aplikasi.

Untuk proses produksi (production build), Vite menggunakan Rollup sebagai bundler yang menghasilkan output yang dioptimasi dengan fitur seperti code splitting, tree shaking, dan minifikasi otomatis. Kombinasi antara kecepatan pengembangan yang tinggi dan hasil build produksi yang optimal menjadikan Vite sebagai pilihan utama untuk proyek-proyek web modern. Dalam penelitian ini, Vite digunakan sebagai build tool untuk mengompilasi dan membundel kode Vue.js serta aset-aset front-end pada sistem U-Market, terintegrasi dengan Laravel melalui plugin Laravel Vite.


2.13 REST API

REST (Representational State Transfer) API adalah arsitektur komunikasi yang memungkinkan front-end atau aplikasi lain berinteraksi dengan back-end menggunakan protokol HTTP dan format data JSON [27]. REST API digunakan sebagai penghubung antara sistem back-end Laravel dengan antarmuka front-end Vue.js pada platform U-Market.

20

Setiap data produk, transaksi, pengguna, keranjang belanja, voucher, dan pelacakan pesanan dikomunikasikan melalui endpoint API yang terstruktur. Penggunaan REST API mendukung modularitas dan skalabilitas sistem, sehingga memudahkan integrasi dalam pengembangan. Selain itu, REST API memiliki prinsip kerja yang sederhana namun efisien karena bersifat stateless, artinya setiap permintaan (request) dari klien harus memuat seluruh informasi yang dibutuhkan tanpa bergantung pada permintaan sebelumnya. Hal ini membuat REST API mudah diimplementasikan dan diintegrasikan dengan berbagai platform seperti web, mobile, maupun aplikasi pihak ketiga. Dalam konteks pengembangan sistem full-stack berbasis Laravel dan Vue.js, REST API berfungsi sebagai kontrak komunikasi antara kedua sisi, di mana back-end menyediakan endpoint yang mengembalikan data dalam format JSON dan front-end mengonsumsi data tersebut untuk ditampilkan kepada pengguna. Pendekatan ini memisahkan concern antara logika bisnis (back-end) dan presentasi (front-end), sehingga masing-masing dapat dikembangkan dan diuji secara independen.


2.14 PHP

PHP adalah bahasa pemrograman yang dirancang untuk menghasilkan halaman web secara interaktif di komputer yang menyajikannya, yang dikenal sebagai web server. Berbeda dengan HTML, di mana peramban web (browser) menggunakan tag dan markup untuk menampilkan halaman, kode PHP dijalankan di antara permintaan halaman dan server web, sehingga dapat menambahkan atau mengubah output HTML dasar [28]. Selain berfungsi sebagai bahasa pemrograman sisi server (server-side scripting), PHP juga memiliki kemampuan untuk berinteraksi dengan basis data, mengelola sesi pengguna, dan memproses formulir secara dinamis. PHP sering digunakan dalam pengembangan aplikasi web modern karena sifatnya yang open source, mudah dipelajari, serta memiliki kompatibilitas tinggi dengan berbagai sistem manajemen basis data seperti MySQL dan PostgreSQL. Dukungan komunitas yang luas serta integrasinya dengan berbagai framework seperti Laravel menjadikan PHP tetap relevan sebagai fondasi utama pengembangan sistem berbasis web yang dinamis dan efisien.

21


2.15 JavaScript

JavaScript adalah bahasa pemrograman tingkat tinggi yang bersifat dinamis, interpreted, dan mendukung paradigma pemrograman berorientasi objek, fungsional, serta berbasis event. Awalnya dirancang sebagai bahasa scripting untuk menambahkan interaktivitas pada halaman web di sisi klien (client-side), JavaScript kini telah berkembang menjadi bahasa pemrograman universal yang juga digunakan di sisi server (server-side) melalui runtime seperti Node.js [29].

Dalam pengembangan web modern, JavaScript berperan fundamental dalam membangun antarmuka pengguna yang dinamis dan responsif. JavaScript memungkinkan manipulasi Document Object Model (DOM) secara langsung, penanganan event pengguna, komunikasi asinkron dengan server melalui teknologi seperti Fetch API dan Axios, serta pengelolaan state aplikasi secara real-time. Dengan adanya standar ECMAScript terbaru (ES6+), JavaScript telah dilengkapi dengan fitur modern seperti arrow functions, destructuring, async/await, modules, dan template literals yang meningkatkan produktivitas pengembang dan kualitas kode [30].

Dalam konteks penelitian ini, JavaScript digunakan sebagai bahasa utama pada sisi front-end melalui framework Vue.js, untuk membangun komponen-komponen interaktif seperti formulir registrasi dengan validasi real-time, peta pelacakan pesanan menggunakan Leaflet.js, grafik dashboard menggunakan Chart.js, serta service worker untuk mendukung fungsionalitas PWA.

22


2.16 Metode Scrum

Menurut Scrum Guide, Scrum adalah kerangka kerja yang membantu tim untuk mengembangkan dan mengelola produk dalam konteks kompleks melalui iterasi yang terstruktur. Scrum tidak menggantikan proses manajemen proyek tradisional, melainkan menyediakan fokus, transparansi, dan adaptasi sehingga pekerjaan yang dilakukan dapat terus dievaluasi dan disempurnakan dalam siklus kerja yang berkala. Kerangka kerja ini umumnya digunakan dalam konteks Agile, yang merupakan pendekatan pengembangan perangkat lunak yang berorientasi pada kolaborasi, nilai bisnis, dan responsif terhadap perubahan kebutuhan pengguna [31].

[Gambar 2.1 Metode Scrum - sertakan gambar yang sama seperti kating]


2.16.1 Scrum Team

Scrum Team merupakan tim yang dibentuk untuk mengembangkan produk secara kolaboratif dengan pendekatan adaptif. Scrum Team bekerja sebagai satu kesatuan yang saling melengkapi dalam mencapai tujuan pengembangan produk. Dalam kerangka kerja Scrum, Scrum Team terdiri atas tiga peran utama, yaitu Product Owner, Scrum Master, dan Developers. Setiap peran memiliki tanggung jawab yang berbeda namun saling terintegrasi untuk memastikan proses pengembangan berjalan efektif dan menghasilkan produk yang bernilai.

23

a. Developers

Developers merupakan anggota Scrum Team yang bertanggung jawab terhadap implementasi teknis dan realisasi produk. Dalam konteks pengembangan full-stack, Developers mencakup pengembang yang menangani baik sisi front-end maupun back-end yang bekerja sama dalam mengembangkan fitur sesuai dengan tujuan Sprint. Tanggung jawab Developers meliputi keterlibatan dalam proses Sprint Planning dan penyusunan Sprint Backlog, memastikan kualitas hasil pengembangan dengan mematuhi definition of done yang telah ditetapkan, serta melakukan penyesuaian rencana kerja secara harian agar tujuan Sprint dapat tercapai. Selain itu, Developers memiliki tanggung jawab bersama sebagai profesional untuk bekerja secara kolaboratif dan menjaga mutu produk yang dikembangkan.

b. Product Owner

Product Owner berperan sebagai pihak yang bertanggung jawab terhadap nilai produk yang dikembangkan oleh Scrum Team. Product Owner bertugas mengelola dan memprioritaskan Product Backlog agar pengembangan produk tetap selaras dengan kebutuhan pengguna dan tujuan proyek. Peran ini juga melibatkan komunikasi dengan pemangku kepentingan untuk memastikan bahwa kebutuhan dan harapan terhadap produk dapat diterjemahkan dengan baik ke dalam item Sprint yang dapat dikembangkan oleh tim.

c. Scrum Master

Scrum Master bertanggung jawab untuk memastikan bahwa penerapan Scrum berjalan sesuai dengan prinsip dan aturan yang telah ditetapkan. Scrum Master berperan sebagai fasilitator yang membantu Scrum Team memahami dan menerapkan Scrum secara efektif, serta menghilangkan hambatan yang dapat mengganggu proses pengembangan. Selain itu, Scrum Master memastikan setiap kegiatan Scrum, seperti Sprint Planning, Daily Scrum, Sprint Review, dan Sprint Retrospective, dapat terlaksana dengan baik.

24


2.16.2 Events Scrum

Scrum membagi proses pengembangan ke dalam serangkaian kegiatan yang dikenal sebagai events atau tahapan, yaitu:

a. Sprint Planning

Tahapan ini merupakan pertemuan awal sebelum Sprint dimulai, di mana tim menentukan pekerjaan apa saja dari Product Backlog yang akan diselesaikan dalam Sprint tersebut. Perencanaan ini menghasilkan Sprint Backlog yang berisi tugas konkret untuk periode Sprint berikutnya.

b. Sprint

Sprint adalah periode kerja yang biasanya berdurasi 1-4 minggu, di mana tim bekerja untuk menghasilkan bagian produk yang dapat diuji (increment). Selama Sprint, tim memfokuskan tugasnya pada pekerjaan yang telah direncanakan tanpa perubahan besar dari luar.

c. Daily Scrum

Daily Scrum adalah rapat harian singkat (maksimal 15 menit) yang dilakukan setiap hari kerja selama Sprint. Tujuan rapat ini adalah untuk menyelaraskan rencana kerja harian, mengevaluasi progres, serta mengidentifikasi hambatan.

d. Sprint Review

Pada akhir Sprint, tim melakukan Sprint Review untuk mempresentasikan hasil yang telah dicapai kepada pemangku kepentingan (stakeholders). Hasil diskusi ini dapat memunculkan umpan balik yang kemudian diperhitungkan dalam Sprint berikutnya.

e. Sprint Retrospective

Tahapan ini dilakukan setelah Sprint Review dan sebelum Sprint Planning berikutnya. Tujuan retrospective adalah melakukan evaluasi proses kerja selama Sprint untuk meningkatkan efektivitas tim pada Sprint mendatang.

25

Scrum menawarkan beberapa kelebihan penting, seperti kemampuan untuk merespons perubahan kebutuhan dengan cepat, meningkatkan kolaborasi tim, serta menyediakan mekanisme evaluasi berkala melalui Sprint. Pendekatan iteratif ini membantu tim untuk mengurangi risiko kegagalan dengan memperkecil ruang lingkup pengerjaan sekaligus mempercepat feedback dari pengguna atau pemangku kepentingan. Faktor-faktor ini menjadikan Scrum sangat populer, terutama dalam pengembangan sistem yang kompleks seperti aplikasi full-stack berbasis web dan mobile yang memerlukan adaptasi terhadap permintaan pasar yang berubah-ubah.


2.16.3 Artifacts Scrum

Artifacts atau luaran yang dihasilkan pada setiap proses Scrum adalah sebagai berikut:

a. Product Backlog

Merupakan daftar prioritas dari seluruh kebutuhan fitur, perbaikan, dan perubahan yang harus dikerjakan dalam pengembangan produk. Product Backlog disusun oleh Product Owner dan menjadi dasar pengaturan pekerjaan dalam Sprint.

b. Sprint Backlog

Merupakan daftar Product Backlog yang dipilih untuk Sprint ditambah rencana untuk memproduksi produk tersebut dan mencapai tujuan Sprint.

c. Increment

Merupakan jumlah item Product Backlog yang diselesaikan dalam Sprint dan nilai total increment di semua Sprint sebelumnya.

26


2.17 Black box Testing

Black-box testing merupakan salah satu metode pengujian perangkat lunak yang berfokus pada fungsi sistem tanpa memperhatikan struktur internal atau logika program yang digunakan untuk menghasilkan keluaran tersebut. Pengujian jenis ini dilakukan dengan tujuan memastikan bahwa perangkat lunak dapat berfungsi sesuai dengan kebutuhan pengguna (user requirements) yang telah ditentukan pada tahap analisis. Penguji hanya mengetahui masukan (input) dan keluaran (output) yang diharapkan, tanpa perlu memahami bagaimana proses internal atau kode sumber bekerja untuk mencapai hasil tersebut. Pendekatan black-box testing cocok diterapkan untuk mengidentifikasi kesalahan pada fungsi, antarmuka, serta kinerja sistem yang berhubungan langsung dengan pengguna. Selain itu, metode ini efektif untuk mendeteksi kesalahan pada logika program, kesalahan implementasi kebutuhan, serta masalah kompatibilitas antar komponen [32].

Dalam konteks pengembangan full-stack, black-box testing diterapkan pada dua sisi sekaligus: pengujian endpoint REST API di sisi back-end untuk memvalidasi respons server, serta pengujian antarmuka pengguna di sisi front-end untuk memastikan interaksi dan navigasi berjalan sesuai skenario.


2.18 Postman

Postman adalah sebuah alat pengujian Application Programming Interface (API) yang memungkinkan pengembang dan penguji perangkat lunak untuk mengirim permintaan HTTP/HTTPS, menerima tanggapan dari server, serta menjalankan skrip pengujian, semuanya dalam satu antarmuka yang terintegrasi. Artikel oleh Kore et al. (2022) menekankan bahwa Postman telah berkembang dari plugin browser sederhana menjadi solusi otomatisasi dan dokumentasi API yang digunakan oleh jutaan pengembang dan ratusan ribu organisasi [33]. Postman mendukung berbagai jenis pengujian seperti pengujian fungsional, integrasi, performa, dan keamanan API melalui fitur koleksi (collections), variabel lingkungan (environment variables), skrip pre-request dan post-response, serta integrasi pipeline CI/CD. Contoh panduan resmi Postman menyebutkan bahwa pengujian API mencakup integration testing, end-to-end testing, regression testing, dan performance testing.

27


2.19 Stress Test

Stress Testing adalah cara untuk melihat bagaimana situasi rawan kegagalan mempengaruhi tingkat stres sistem. Pengujian akan dilakukan dengan variabel jumlah pengguna dalam satu waktu dan akan menguji respon sistem ketika diakses oleh pengguna dalam jumlah besar dan dalam jangka waktu tertentu [34]. Tujuan dari Stress Testing adalah untuk memperkirakan beban maksimum yang dapat ditangani oleh server web. Dalam konteks pengembangan full-stack, stress testing tidak hanya menguji performa back-end API, tetapi juga memastikan bahwa front-end dapat menangani dan merender respons data dalam jumlah besar tanpa mengalami degradasi performa.


2.20 Apache JMeter

Apache JMeter adalah proyek sumber terbuka yang digunakan untuk alat pengujian kinerja dan beban. Apache JMeter akan membuat beberapa simulasi pengguna yang akan mengakses server dengan jumlah pengguna yang berbeda dan interval waktu permintaan tergantung pada konfigurasi yang dilakukan pada Apache JMeter [34]. Dalam penelitian ini, Apache JMeter digunakan untuk melakukan stress testing terhadap endpoint REST API yang dikembangkan pada sistem U-Market guna mengukur waktu respons, throughput, dan stabilitas sistem dalam menangani permintaan secara bersamaan.


2.21 Payment Gateway

Payment gateway merupakan layanan perantara dalam sistem transaksi elektronik yang berfungsi menghubungkan pelanggan, merchant, dan lembaga perbankan dalam proses pembayaran daring secara aman. Dalam praktik e-commerce, payment gateway berperan sebagai pihak ketiga tepercaya (trusted third party) yang menerima, mengenkripsi, serta meneruskan data pembayaran pelanggan untuk proses otorisasi tanpa harus mengekspos informasi sensitif kepada merchant secara langsung. Konsep ini antara lain dijelaskan oleh Kyaw Zay Oo dalam artikelnya yang berjudul Design and Implementation of Electronic Payment Gateway for Secure Online Payment System [35], yang menekankan pentingnya mekanisme enkripsi dan validasi dalam menjaga kerahasiaan serta integritas data transaksi. Dengan memanfaatkan protokol keamanan seperti SSL/TLS dan algoritma kriptografi kunci publik, payment gateway tidak hanya memastikan proses otorisasi berjalan secara real time, tetapi juga meminimalkan risiko penyalahgunaan data, penipuan, serta sengketa transaksi.

28

Payment gateway dalam implementasinya tidak hanya berfungsi sebagai penghubung teknis antara sistem merchant dan lembaga keuangan, tetapi juga menjadi bagian integral dari arsitektur sistem informasi yang mendukung efisiensi dan keandalan transaksi daring. Integrasi payment gateway, seperti Midtrans, memungkinkan proses verifikasi pembayaran dilakukan secara otomatis melalui mekanisme notifikasi (callback) dan Application Programming Interface (API), sehingga meminimalkan kesalahan pencatatan serta mempercepat konfirmasi transaksi. Selain itu, sistem ini menyediakan berbagai metode pembayaran dalam satu platform terintegrasi, yang pada akhirnya meningkatkan fleksibilitas serta kenyamanan pengguna dalam bertransaksi. Penerapan tersebut menunjukkan bahwa digitalisasi sistem pembayaran melalui payment gateway mampu meningkatkan efektivitas pengelolaan transaksi dan mengurangi ketergantungan pada proses manual [36].


2.22 MidTrans

Midtrans merupakan salah satu penyedia layanan payment gateway terkemuka di Indonesia yang berfungsi sebagai perantara antara penjual dan berbagai lembaga keuangan untuk memfasilitasi transaksi daring secara aman dan efisien. Melalui Midtrans, pengguna dapat melakukan pembayaran menggunakan beragam metode seperti kartu kredit, virtual account, dompet digital, maupun QRIS, tanpa perlu melakukan integrasi langsung dengan setiap penyedia layanan pembayaran. Layanan ini membantu pelaku usaha maupun pengembang sistem e-commerce dalam mempercepat proses transaksi sekaligus meningkatkan kepercayaan pelanggan terhadap sistem pembayaran digital [37]. Dokumentasi resmi Midtrans menjelaskan bahwa sistem ini dibangun untuk mendukung berbagai model integrasi, seperti Snap untuk integrasi cepat berbasis hosted payment page, Core API untuk integrasi kustom berbasis REST API, serta Webhook Notification untuk mengirimkan status transaksi secara real-time dari server Midtrans ke server merchant.

29

Dalam aspek keamanan, Midtrans telah memperoleh sertifikasi Payment Card Industry Data Security Standard (PCI-DSS) Level 1, yang merupakan standar keamanan tertinggi dalam pengelolaan data kartu pembayaran. Selain itu, Midtrans menerapkan teknologi Advanced Encryption Standard (AES-256) serta sistem deteksi penipuan berbasis machine learning bernama Aegis guna menjaga keamanan transaksi dan mencegah terjadinya aktivitas mencurigakan. Keunggulan tersebut menjadikan Midtrans banyak digunakan pada berbagai platform e-commerce di Indonesia karena keandalannya dalam menangani proses otorisasi, verifikasi, dan notifikasi transaksi secara otomatis.

Pengembangan sistem payment gateway berbasis Midtrans memperlihatkan kontribusi signifikan terhadap modernisasi layanan berbasis digital, khususnya dalam konteks transformasi sistem pembayaran konvensional menuju sistem elektronik yang lebih adaptif. Dengan memanfaatkan enkripsi data dan protokol keamanan yang terstandarisasi, integrasi ini mampu menjaga keamanan data transaksi sekaligus memastikan proses otorisasi berjalan secara real time. Implementasi tersebut tidak hanya meningkatkan keamanan, tetapi juga memperkuat kepercayaan pengguna terhadap sistem pembayaran digital yang digunakan. Hasil pengembangan yang dilakukan dalam penelitian terkait menunjukkan bahwa penggunaan payment gateway mendukung peningkatan kualitas layanan dan efisiensi operasional pada sistem yang terdigitalisasi [38].

Dalam penelitian ini, Midtrans diintegrasikan dengan sistem U-Market melalui model Snap untuk memproses pembayaran pada fitur checkout. Integrasi mencakup pembuatan transaksi melalui back-end Laravel, redirect pengguna ke halaman pembayaran Midtrans, serta penerimaan webhook notification untuk memperbarui status transaksi secara otomatis di database.

30


2.23 Penelitian Terkait

Berdasarkan berbagai penelitian sebelumnya, metode Scrum, framework Laravel, serta teknologi front-end modern telah banyak digunakan dalam pengembangan sistem informasi dan aplikasi e-commerce berbasis web. Tinjauan terhadap beberapa penelitian berikut bertujuan untuk memperkuat dasar teori dan memberikan gambaran mengenai relevansi metode serta teknologi yang digunakan dalam penelitian ini.

Penelitian yang dilakukan oleh Fauzi dan Darmawan (2023) membahas pembangunan aplikasi e-commerce berbasis website menggunakan framework Laravel untuk mendukung aktivitas penjualan UMKM. Penelitian ini menekankan pemanfaatan Laravel dalam membangun sistem yang terstruktur, aman, dan efisien dengan menerapkan konsep MVC. Sistem yang dikembangkan mampu menangani proses promosi produk, pemesanan, hingga pembayaran secara daring. Hasil penelitian menunjukkan bahwa penggunaan Laravel dapat mempercepat proses pengembangan website e-commerce serta mempermudah pengelolaan data transaksi dan produk secara terpusat. Penelitian ini menjadi rujukan penting dalam pengembangan sistem e-commerce berbasis web yang berfokus pada pengelolaan back-end yang terstruktur [39].

Penelitian selanjutnya dilakukan oleh Andipradana dan Hartomo (2021) yang merancang dan membangun aplikasi penjualan online berbasis web dengan menerapkan metode Scrum sebagai pendekatan pengembangan sistem. Penelitian ini menyoroti fleksibilitas Scrum dalam menangani perubahan kebutuhan sistem selama proses pengembangan. Aplikasi yang dihasilkan mampu mendukung pengelolaan produk, transaksi, serta pelaporan penjualan secara digital. Hasil penelitian menunjukkan bahwa metode Scrum efektif digunakan pada pengembangan sistem penjualan online karena memungkinkan iterasi cepat dan kolaborasi intensif antar tim pengembang, sehingga sistem yang dihasilkan lebih adaptif terhadap kebutuhan pengguna [40].

31

Penelitian lain yang dilakukan oleh Syahputra dkk. (2024) membahas rancang bangun sistem informasi penjualan mainan edukasi berbasis web menggunakan metode Scrum. Penelitian ini menekankan pembagian proyek ke dalam beberapa Sprint untuk menghasilkan fitur secara bertahap. Sistem yang dikembangkan mampu meningkatkan efisiensi pencatatan transaksi, pengelolaan stok, serta penyusunan laporan penjualan. Hasil pengujian menunjukkan bahwa sistem memiliki tingkat fungsionalitas yang baik dan mudah digunakan. Penelitian ini memperkuat bahwa metode Scrum sangat sesuai untuk pengembangan sistem informasi penjualan berbasis web yang membutuhkan fleksibilitas dan evaluasi berkelanjutan [41].

Rahmouni dkk. (2023) dalam penelitiannya membahas pendekatan pemodelan untuk menghasilkan kode aplikasi e-commerce berbasis Laravel dengan menerapkan Model Driven Architecture (MDA). Penelitian ini menjelaskan bagaimana pemodelan sistem menggunakan UML dapat ditransformasikan secara sistematis menjadi kode program Laravel yang mengikuti arsitektur MVC. Hasil penelitian menunjukkan bahwa pendekatan pemodelan ini mampu meningkatkan konsistensi desain sistem dan mempercepat proses pengembangan back-end aplikasi e-commerce. Penelitian ini relevan sebagai landasan konseptual dalam perancangan arsitektur sistem yang terstruktur dan mudah dikembangkan [42].

Penelitian oleh Aditya dkk. (2022) membahas pengembangan sistem e-commerce dengan pemanfaatan payment gateway Midtrans menggunakan framework Laravel. Penelitian ini difokuskan pada otomatisasi proses pembayaran yang sebelumnya dilakukan secara manual. Hasil penelitian menunjukkan bahwa integrasi Midtrans mampu mempercepat proses verifikasi pembayaran dan meningkatkan keandalan sistem transaksi. Selain itu, pengujian sistem menggunakan metode blackbox menunjukkan bahwa seluruh fungsi sistem berjalan dengan valid. Penelitian ini menjadi referensi penting dalam pengembangan fitur checkout dan manajemen transaksi pada sistem e-commerce [43].

32

Penelitian selanjutnya dilakukan oleh Ayurira dan Fajri (2024) yang mengimplementasikan metode Scrum dalam pengembangan website e-commerce pada Twins Petshop. Penelitian ini menyoroti keunggulan Scrum dalam meningkatkan kolaborasi tim dan responsivitas sistem terhadap perubahan kebutuhan. Sistem yang dikembangkan diuji menggunakan metode blackbox dan menunjukkan hasil fungsional yang baik. Penelitian ini menegaskan bahwa metode Scrum efektif diterapkan pada pengembangan website e-commerce untuk bisnis skala kecil dan menengah, khususnya dalam menghasilkan sistem yang adaptif dan berkualitas [44].

Penelitian oleh Sinaga dkk. (2021) membahas implementasi framework Laravel dengan konsep MVC dalam pengembangan aplikasi e-commerce berbasis web. Penelitian ini menekankan pemisahan antara model, view, dan controller untuk menghasilkan struktur kode yang rapi dan mudah dikelola. Sistem yang dikembangkan mendukung berbagai peran pengguna serta pengelolaan data transaksi dan produk. Hasil penelitian menunjukkan bahwa penggunaan Laravel dengan arsitektur MVC dapat meningkatkan efisiensi pengembangan dan pemeliharaan sistem e-commerce [45].

Penelitian oleh Tandel dan Jamadar (2018) membahas perbandingan antara Progressive Web App (PWA) dan aplikasi native dalam hal performa, ukuran, dan pengalaman pengguna. Hasil penelitian menunjukkan bahwa PWA mampu memberikan pengalaman yang setara dengan aplikasi native untuk kasus penggunaan tertentu, dengan keunggulan pada ukuran yang lebih kecil dan kemudahan distribusi tanpa app store. Penelitian ini menjadi rujukan dalam implementasi PWA pada platform U-Market [46].

33

Penelitian oleh Biorn-Hansen dkk. (2020) menganalisis perbandingan performa antara aplikasi hybrid yang dibangun menggunakan framework cross-platform (termasuk Capacitor/Ionic) dengan aplikasi native. Hasil penelitian menunjukkan bahwa untuk aplikasi dengan tingkat kompleksitas UI menengah seperti e-commerce, pendekatan hybrid memberikan performa yang memadai dengan keunggulan signifikan pada efisiensi pengembangan. Penelitian ini memperkuat keputusan penggunaan Capacitor dalam penelitian ini [47].

Berdasarkan penelitian terkait yang telah diuraikan, dapat disimpulkan bahwa sebagian besar penelitian telah berhasil membangun sistem e-commerce berbasis website dengan memanfaatkan framework Laravel sebagai kerangka kerja pengembangan aplikasi. Penelitian-penelitian tersebut umumnya berfokus pada implementasi fitur dasar e-commerce, seperti pengelolaan produk, transaksi, dan laporan penjualan, serta menekankan keunggulan Laravel dalam mendukung arsitektur MVC yang terstruktur dan mudah dikembangkan. Selain itu, beberapa penelitian juga telah menerapkan metode Scrum sebagai pendekatan pengembangan sistem untuk menghasilkan aplikasi yang adaptif terhadap perubahan kebutuhan pengguna.

34

Namun demikian, masih terdapat beberapa celah penelitian (research gap) yang dapat diidentifikasi. Pertama, sebagian besar penelitian masih memisahkan pengembangan back-end dan front-end tanpa integrasi yang terpadu dalam satu codebase menggunakan pendekatan full-stack. Kedua, implementasi Progressive Web App (PWA) pada sistem e-commerce komunitas lokal masih sangat terbatas, padahal teknologi ini mampu meningkatkan pengalaman pengguna secara signifikan melalui dukungan akses offline dan instalasi tanpa app store. Ketiga, penggunaan teknologi Capacitor untuk mengemas aplikasi web menjadi aplikasi mobile native belum banyak dieksplorasi dalam konteks e-commerce berbasis Laravel dan Vue.js. Keempat, fitur-fitur lanjutan seperti pelacakan pesanan berbasis peta real-time, sistem voucher, dan multi-gambar produk belum banyak diimplementasikan secara terintegrasi dalam satu sistem. Kelima, penerapan metode Scrum pada penelitian terdahulu umumnya belum dikaitkan secara rinci dengan penyusunan Product Backlog, pembagian Sprint, dan evaluasi hasil pengembangan pada setiap Sprint secara sistematis untuk pengembangan full-stack.

Berdasarkan gap penelitian tersebut, penelitian ini dilakukan untuk melengkapi dan mengembangkan penelitian-penelitian sebelumnya dengan memfokuskan pada pengembangan full-stack sistem e-commerce U-Market. Penelitian ini mengintegrasikan sisi back-end menggunakan framework Laravel dengan front-end menggunakan Vue.js dalam satu codebase, dilengkapi implementasi PWA untuk mendukung akses offline dan instalasi langsung, serta Capacitor untuk menghasilkan aplikasi mobile Android dari codebase yang sama. Selain itu, penelitian ini juga mengimplementasikan fitur-fitur lanjutan seperti pelacakan pesanan berbasis peta Leaflet, sistem voucher, multi-gambar produk, verifikasi email, dan integrasi payment gateway Midtrans, serta menerapkan metode Scrum secara terstruktur melalui penyusunan Product Backlog dan pelaksanaan Sprint secara bertahap. Dengan demikian, penelitian ini diharapkan dapat memberikan kontribusi dalam pengembangan sistem e-commerce yang lebih komprehensif, modern, dan mudah diakses melalui berbagai platform, sekaligus memperkaya kajian ilmiah terkait pengembangan full-stack e-commerce berbasis Laravel, Vue.js, PWA, dan Capacitor dengan metode Scrum.

35


================================================================================
DAFTAR PUSTAKA
================================================================================

[1]   Laudon, K. C., & Traver, C. G. (2022). E-Commerce 2021–2022: Business, Technology, Society (16th ed.). Boston: Pearson Education.
[2]   Kotler, P., & Armstrong, G. (2020). Principles of Marketing (18th ed.). London: Pearson Education.
[3]   Google Developers. (2023). Progressive Web Apps: What Are Progressive Web Apps? Web.dev. https://web.dev/progressive-web-apps/
[4]   Ionic Team. (2024). Capacitor Documentation: Cross-Platform Native Runtime. Ionic Framework. https://capacitorjs.com/docs
[5]   Schwaber, K., & Sutherland, J. (2020). The Scrum Guide: The Definitive Guide to Scrum: The Rules of the Game. Scrum.org.
[6]   Chaffey, D. (2019). Digital Business and E-Commerce Management: Strategy, Implementation and Practice (7th ed.). Harlow: Pearson Education.
[7]   Turban, E., Outland, J., King, D., Lee, J. K., Liang, T. P., & Turban, D. C. (2018). Electronic Commerce 2018: A Managerial and Social Networks Perspective (9th ed.). Cham: Springer.
[8]   Sarmanela, S., Samiya, S., & Yuliana, Y. (2023). Pengembangan Backend Application Programming Interface (API) Menggunakan Framework Laravel. Jurnal Informatika dan Rekayasa Perangkat Lunak, 5(2), 142–151.
[9]   Duckett, J. (2014). Web Design with HTML, CSS, JavaScript and jQuery Set. Indianapolis: John Wiley & Sons.
[10]  Ater, T. (2017). Building Progressive Web Apps: Bringing Mobile Web to Life. Sebastopol: O'Reilly Media.
[11]  Mozilla Developer Network (MDN). (2024). Service Worker API. MDN Web Docs. https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API
[12]  World Wide Web Consortium (W3C). (2023). Web App Manifest Specification. W3C Working Draft. https://www.w3.org/TR/appmanifest/
[13]  Xanthopoulos, S., & Xinogalos, S. (2013). A Comparative Analysis of Cross-Platform Development Approaches for Mobile Applications. Proceedings of the 6th Balkan Conference in Informatics (BCI '13), pp. 213–220.
[14]  Biorn-Hansen, A., Grønli, T. M., & Ghinea, G. (2020). An Empirical Investigation of Performance Overhead in Cross-Platform Mobile Development Frameworks. Empirical Software Engineering, 25(4), 2997–3040.
[15]  Ionic Team. (2024). Capacitor: Build Cross-Platform Apps with Web Technologies. https://capacitorjs.com
[16]  Griffiths, M. (2021). Hybrid Mobile Development with Ionic and Capacitor. Birmingham: Packt Publishing.
[17]  Hidayah, A. N., & Rofiqoh, N. (2024). Analisis Efisiensi Penggunaan Visual Studio Code dalam Pengembangan Aplikasi Web. Jurnal Teknologi Sistem Informasi, 8(1), 55–63.
[18]  Fowler, M. (2018). UML Distilled: A Brief Guide to the Standard Object Modeling Language (3rd ed.). Boston: Addison-Wesley Professional.
[19]  Dennis, A., Wixom, B. H., & Tegarden, D. (2020). Systems Analysis and Design: An Object-Oriented Approach with UML (6th ed.). Hoboken: John Wiley & Sons.
[20]  Pressman, R. S., & Maxim, B. R. (2020). Software Engineering: A Practitioner's Approach (9th ed.). New York: McGraw-Hill Education.
[21]  Connolly, T., & Begg, C. (2015). Database Systems: A Practical Approach to Design, Implementation, and Management (6th ed.). Boston: Pearson Education.
[22]  Oracle Corporation. (2024). MySQL 8.0 Reference Manual. Oracle Documentation. https://dev.mysql.com/doc/refman/8.0/en/
[23]  Stauffer, M. (2019). Laravel: Up & Running: A Framework for Building Modern PHP Apps (2nd ed.). Sebastopol: O'Reilly Media.
[24]  You, E. (2024). Vue.js: The Progressive JavaScript Framework. Official Documentation. https://vuejs.org/
[25]  Filipova, O. (2016). Learning Vue.js 2: Learn How to Build Amazing and Complex Reactive Web Applications. Birmingham: Packt Publishing.
[26]  You, E. (2024). Vite: Next Generation Frontend Tooling. https://vitejs.dev/
[27]  Fielding, R. T. (2000). Architectural Styles and the Design of Network-based Software Architectures (Doctoral dissertation). University of California, Irvine.
[28]  Nixon, R. (2021). Learning PHP, MySQL & JavaScript: With jQuery, CSS & HTML5 (6th ed.). Sebastopol: O'Reilly Media.
[29]  Flanagan, D. (2020). JavaScript: The Definitive Guide: Master the World's Most-Used Programming Language (7th ed.). Sebastopol: O'Reilly Media.
[30]  Haverbeke, M. (2018). Eloquent JavaScript: A Modern Introduction to Programming (3rd ed.). San Francisco: No Starch Press.
[31]  Rubin, K. S. (2012). Essential Scrum: A Practical Guide to the Most Popular Agile Process. Boston: Addison-Wesley Professional.
[32]  Myers, G. J., Sandler, C., & Badgett, T. (2011). The Art of Software Testing (3rd ed.). Hoboken: John Wiley & Sons.
[33]  Postman Inc. (2024). Postman API Platform Documentation. https://learning.postman.com/docs/
[34]  Apache Software Foundation. (2024). Apache JMeter User's Manual. https://jmeter.apache.org/usermanual/
[35]  Oo, K. Z. (2020). Design and Implementation of Electronic Payment Gateway for Secure Online Payment System. International Journal of Computer Applications, 175(20), 12–18.
[36]  Laudon, K. C., & Guercio Traver, C. (2021). E-Commerce: Business, Technology, Society. Boston: Pearson.
[37]  Midtrans. (2024). Midtrans Technical Documentation: Snap & Core API. https://docs.midtrans.com/
[38]  Bank Indonesia. (2023). Standar Nasional Quick Response Code Pembayaran (QRIS). Jakarta: Bank Indonesia.
[39]  Fauzi, A., & Darmawan, I. (2023). Pembangunan Aplikasi E-Commerce Berbasis Web Menggunakan Framework Laravel untuk UMKM. Jurnal Rekayasa Sistem dan Teknologi Informasi, 7(3), 412–420.
[40]  Andipradana, A., & Hartomo, K. D. (2021). Rancang Bangun Aplikasi Penjualan Online Berbasis Web Menggunakan Metode Scrum. JATISI (Jurnal Teknik Informatika dan Sistem Informasi), 8(1), 161–172.
[41]  Syahputra, R., dkk. (2024). Rancang Bangun Sistem Informasi Penjualan Mainan Edukasi Berbasis Web dengan Metode Scrum. Jurnal Ilmiah Komputasi, 23(1), 89–98.
[42]  Rahmouni, M., dkk. (2023). A Model-Driven Approach for Generating Laravel E-Commerce Web Applications. International Journal of Advanced Computer Science and Applications, 14(6), 321–330.
[43]  Aditya, R., dkk. (2022). Implementasi Payment Gateway Midtrans pada Sistem Penjualan Berbasis Web Framework Laravel. Jurnal Informatika Terpadu, 8(2), 105–112.
[44]  Ayurira, N., & Fajri, H. (2024). Implementasi Metode Scrum dalam Pengembangan Website E-Commerce Twins Petshop. Jurnal Sistem Komputer dan Informatika, 5(3), 254–263.
[45]  Sinaga, B., dkk. (2021). Implementasi Framework Laravel dengan Arsitektur MVC pada Aplikasi Penjualan Online. Jurnal Teknologi Informasi dan Rekayasa Komputer, 2(1), 45–54.
[46]  Tandel, S. S., & Jamadar, A. (2018). A Review on Progressive Web App for Mobile and Desktop Experiences. International Journal of Innovative Research in Science, Engineering and Technology, 7(5), 5621–5626.
[47]  Biorn-Hansen, A., dkk. (2020). Performance Benchmarking of Cross-Platform Frameworks in Mobile Application Development. IEEE Access, 8, 120456–120472.

================================================================================
CATATAN UNTUK PENULIS:
================================================================================

1. Ganti [NAMA ANDA] dan [NPM ANDA] dengan data diri Anda.
2. Isi bagian RIWAYAT HIDUP, PERSEMBAHAN, MOTTO, dan SANWACANA.
3. Referensi [1]-[47] perlu dicocokkan dengan sumber asli kating dan
   ditambah sumber baru untuk PWA, Capacitor, Vue.js, Vite, dan JavaScript.
4. Untuk referensi yang bertanda "sama dengan kating ref [x]", gunakan
   sumber yang sama persis dari skripsi kating.
5. Tambahkan gambar dan tabel sesuai kebutuhan (Gambar 2.1 Metode Scrum).
6. Nomor halaman di daftar isi bersifat estimasi, sesuaikan setelah
   dokumen final di Word.
7. Format akhir harus disesuaikan ke Microsoft Word dengan margin, font,
   dan spacing sesuai panduan skripsi FT Unila.
