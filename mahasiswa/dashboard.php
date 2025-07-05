<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header_mahasiswa.php';

$mahasiswa_id = $_SESSION['user_id'];

// Hitung jumlah praktikum yang diikuti
$stmt_praktikum = $conn->prepare("SELECT COUNT(*) as total FROM pendaftaran WHERE mahasiswa_id = ?");
$stmt_praktikum->bind_param("i", $mahasiswa_id);
$stmt_praktikum->execute();
$jumlah_praktikum_diikuti = $stmt_praktikum->get_result()->fetch_assoc()['total'];

// Hitung jumlah tugas sudah dinilai
$stmt_selesai = $conn->prepare("SELECT COUNT(*) as total FROM laporan WHERE mahasiswa_id = ? AND nilai IS NOT NULL");
$stmt_selesai->bind_param("i", $mahasiswa_id);
$stmt_selesai->execute();
$jumlah_tugas_selesai = $stmt_selesai->get_result()->fetch_assoc()['total'];

// Hitung jumlah tugas menunggu nilai
$stmt_menunggu = $conn->prepare("SELECT COUNT(*) as total FROM laporan WHERE mahasiswa_id = ? AND nilai IS NULL");
$stmt_menunggu->bind_param("i", $mahasiswa_id);
$stmt_menunggu->execute();
$jumlah_tugas_menunggu = $stmt_menunggu->get_result()->fetch_assoc()['total'];

// Ambil Notifikasi Terbaru (laporan yang baru dinilai)
$stmt_notif = $conn->prepare(
    "SELECT m.nama_modul, mp.nama_praktikum, l.nilai 
     FROM laporan l
     JOIN modul m ON l.modul_id = m.id
     JOIN mata_praktikum mp ON m.praktikum_id = mp.id
     WHERE l.mahasiswa_id = ? AND l.nilai IS NOT NULL ORDER BY l.tanggal_kumpul DESC LIMIT 3"
);
$stmt_notif->bind_param("i", $mahasiswa_id);
$stmt_notif->execute();
$notifikasi = $stmt_notif->get_result();
?>

<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white rounded-2xl shadow-2xl mb-8">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/30 to-purple-600/30"></div>
    <div class="relative px-8 py-12 md:py-16">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Selamat Datang Kembali,
                <span class="block text-yellow-300"><?php echo htmlspecialchars($_SESSION['nama']); ?>!</span>
            </h1>
            <p class="text-xl md:text-2xl opacity-90 mb-6 leading-relaxed">
                Terus semangat dalam menyelesaikan semua modul praktikummu. 
                <span class="block text-blue-200">Raih prestasi terbaikmu hari ini!</span>
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="praktikum_saya.php" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-lg inline-flex items-center">
                    <i class="fas fa-book mr-2"></i>
                    Lihat Praktikum Saya
                </a>
                <a href="praktikum_katalog.php" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300 inline-flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Cari Praktikum Baru
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white bg-opacity-10 rounded-full -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-yellow-400 bg-opacity-20 rounded-full -ml-24 -mb-24"></div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Praktikum Diikuti -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl">
                <i class="fas fa-graduation-cap text-white text-2xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Total</span>
        </div>
        <div class="text-4xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
            <?php echo $jumlah_praktikum_diikuti; ?>
        </div>
        <div class="text-lg text-gray-600 font-medium">Praktikum Diikuti</div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
            <span>Aktif mengikuti</span>
        </div>
    </div>

    <!-- Tugas Dinilai -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl">
                <i class="fas fa-check-circle text-white text-2xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Selesai</span>
        </div>
        <div class="text-4xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
            <?php echo $jumlah_tugas_selesai; ?>
        </div>
        <div class="text-lg text-gray-600 font-medium">Tugas Dinilai</div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <i class="fas fa-medal text-yellow-500 mr-1"></i>
            <span>Sudah dinilai</span>
        </div>
    </div>

    <!-- Tugas Menunggu -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-3 rounded-xl">
                <i class="fas fa-clock text-white text-2xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Pending</span>
        </div>
        <div class="text-4xl font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition-colors">
            <?php echo $jumlah_tugas_menunggu; ?>
        </div>
        <div class="text-lg text-gray-600 font-medium">Tugas Menunggu</div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <i class="fas fa-hourglass-half text-orange-500 mr-1"></i>
            <span>Menunggu nilai</span>
        </div>
    </div>
</div>

<!-- Progress Overview -->
<div class="bg-white p-6 rounded-2xl shadow-lg mb-8 border border-gray-100">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-chart-line mr-3 text-blue-600"></i>
        Ringkasan Progress
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-600">Tugas Selesai</span>
                <span class="text-sm font-bold text-green-600">
                    <?php echo $jumlah_tugas_selesai; ?>/<?php echo $jumlah_tugas_selesai + $jumlah_tugas_menunggu; ?>
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-500" 
                     style="width: <?php echo ($jumlah_tugas_selesai + $jumlah_tugas_menunggu) > 0 ? ($jumlah_tugas_selesai / ($jumlah_tugas_selesai + $jumlah_tugas_menunggu)) * 100 : 0; ?>%">
                </div>
            </div>
        </div>
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-600">Praktikum Aktif</span>
                <span class="text-sm font-bold text-blue-600"><?php echo $jumlah_praktikum_diikuti; ?></span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-trophy text-yellow-500"></i>
                <span class="text-sm text-gray-600">
                    <?php if ($jumlah_praktikum_diikuti > 0): ?>
                        Kamu sedang mengikuti <?php echo $jumlah_praktikum_diikuti; ?> praktikum
                    <?php else: ?>
                        Belum ada praktikum yang diikuti
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Notifikasi -->
<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-bell mr-3 text-yellow-500"></i>
            Notifikasi Terbaru
        </h3>
        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">
            <?php echo $notifikasi->num_rows; ?> Baru
        </span>
    </div>
    
    <div class="space-y-4">
        <?php if ($notifikasi->num_rows > 0): ?>
            <?php while($notif = $notifikasi->fetch_assoc()): ?>
            <div class="flex items-start p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-100 hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-2 rounded-lg mr-4">
                    <i class="fas fa-star text-white"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-semibold text-gray-800">Nilai Baru Tersedia!</h4>
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs font-medium">
                            Nilai: <?php echo htmlspecialchars($notif['nilai']); ?>
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Nilai untuk <span class="font-medium text-blue-600"><?php echo htmlspecialchars($notif['nama_praktikum'] . ' - ' . $notif['nama_modul']); ?></span> telah diberikan.
                    </p>
                    <div class="mt-2 flex items-center text-xs text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        <span>Baru saja</span>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada notifikasi baru</h4>
                <p class="text-gray-500">Notifikasi akan muncul ketika ada tugas yang sudah dinilai</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-2xl border border-gray-200">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-rocket mr-3 text-purple-600"></i>
        Aksi Cepat
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="praktikum_saya.php" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-blue-100 p-3 rounded-lg mr-4 group-hover:bg-blue-200 transition-colors">
                <i class="fas fa-book text-blue-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Praktikum</h4>
                <p class="text-sm text-gray-600">Lihat praktikum saya</p>
            </div>
        </a>
        
        <a href="praktikum_katalog.php" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-green-100 p-3 rounded-lg mr-4 group-hover:bg-green-200 transition-colors">
                <i class="fas fa-search text-green-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Cari</h4>
                <p class="text-sm text-gray-600">Katalog praktikum</p>
            </div>
        </a>
        
        <a href="#" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-purple-100 p-3 rounded-lg mr-4 group-hover:bg-purple-200 transition-colors">
                <i class="fas fa-chart-bar text-purple-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Nilai</h4>
                <p class="text-sm text-gray-600">Lihat hasil nilai</p>
            </div>
        </a>
        
        <a href="#" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-orange-100 p-3 rounded-lg mr-4 group-hover:bg-orange-200 transition-colors">
                <i class="fas fa-question-circle text-orange-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Bantuan</h4>
                <p class="text-sm text-gray-600">Panduan sistem</p>
            </div>
        </a>
    </div>
</div>

<style>
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.animate-pulse-slow {
    animation: pulse 3s infinite;
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
}
</style>

<?php
require_once 'templates/footer_mahasiswa.php';
?>