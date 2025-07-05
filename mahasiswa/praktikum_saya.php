<?php
$pageTitle = 'Praktikum Saya';
$activePage = 'praktikum_saya';
require_once 'templates/header_mahasiswa.php';

$mahasiswa_id = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT mp.id, mp.nama_praktikum, mp.kode_praktikum, mp.deskripsi
     FROM mata_praktikum mp
     JOIN pendaftaran p ON mp.id = p.praktikum_id
     WHERE p.mahasiswa_id = ?"
);
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded-2xl shadow-xl mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Praktikum Saya</h1>
            <p class="text-blue-100 text-lg">Kelola dan pantau progress praktikum yang sedang Anda ikuti</p>
        </div>
        <div class="hidden md:block">
            <div class="bg-white bg-opacity-20 p-4 rounded-xl">
                <i class="fas fa-book-open text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Praktikum Grid -->
<div class="space-y-6">
    <?php if ($result->num_rows > 0): ?>
        <?php $index = 0; ?>
        <?php while($praktikum = $result->fetch_assoc()): ?>
            <?php $index++; ?>
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-4">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-3 rounded-xl mr-4">
                                    <i class="fas fa-flask text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                        <?php echo htmlspecialchars($praktikum['nama_praktikum']); ?>
                                    </h3>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium">
                                            <?php echo htmlspecialchars($praktikum['kode_praktikum']); ?>
                                        </span>
                                        <span class="text-gray-500 text-sm">•</span>
                                        <span class="text-gray-500 text-sm">Praktikum <?php echo $index; ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 leading-relaxed mb-4">
                                <?php echo htmlspecialchars($praktikum['deskripsi']); ?>
                            </p>
                            
                            <!-- Progress Info -->
                            <div class="flex items-center space-x-6 text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-tasks mr-2 text-blue-500"></i>
                                    <span>Modul Tersedia</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-yellow-500"></i>
                                    <span>Sedang Berlangsung</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star mr-2 text-purple-500"></i>
                                    <span>Aktif</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 mt-4 lg:mt-0">
                            <a href="praktikum_detail.php?id=<?php echo $praktikum['id']; ?>" 
                               class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center group">
                                <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform"></i>
                                Lihat Detail & Tugas
                            </a>
                            
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600">Progress Keseluruhan</span>
                        <span class="text-sm font-bold text-blue-600">75%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-500" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        
        <!-- Summary Stats -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 p-6 rounded-2xl border border-green-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-xl mr-4">
                        <i class="fas fa-chart-line text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Total Praktikum Diikuti</h3>
                        <p class="text-gray-600">Anda sedang mengikuti <?php echo $result->num_rows; ?> praktikum</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-green-600"><?php echo $result->num_rows; ?></div>
                    <div class="text-sm text-gray-500">Praktikum</div>
                </div>
            </div>
        </div>
        
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-book-open text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-600 mb-4">Belum Ada Praktikum</h3>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">
                Anda belum mendaftar pada mata praktikum apapun. Mulai jelajahi katalog praktikum dan daftar sekarang!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="praktikum_katalog.php" 
                   class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Cari Praktikum
                </a>
                <a href="dashboard.php" 
                   class="bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-bold py-3 px-8 rounded-xl transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Tips Section -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-2xl border border-blue-200">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-lightbulb mr-3 text-yellow-500"></i>
        Tips Sukses Praktikum
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-2">
                <i class="fas fa-clock text-blue-500 mr-2"></i>
                <h4 class="font-semibold text-gray-800">Kelola Waktu</h4>
            </div>
            <p class="text-sm text-gray-600">Buat jadwal rutin untuk menyelesaikan tugas praktikum tepat waktu</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-2">
                <i class="fas fa-users text-green-500 mr-2"></i>
                <h4 class="font-semibold text-gray-800">Kolaborasi</h4>
            </div>
            <p class="text-sm text-gray-600">Diskusi dengan teman untuk memahami materi dengan lebih baik</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-2">
                <i class="fas fa-question-circle text-purple-500 mr-2"></i>
                <h4 class="font-semibold text-gray-800">Bertanya</h4>
            </div>
            <p class="text-sm text-gray-600">Jangan ragu untuk bertanya kepada dosen atau asisten jika ada kesulitan</p>
        </div>
    </div>
</div>

<style>
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>

<?php require_once 'templates/footer_mahasiswa.php'; ?>