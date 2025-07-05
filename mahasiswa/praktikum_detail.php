<?php
$pageTitle = 'Detail Praktikum';
$activePage = 'praktikum_saya';
require_once 'templates/header_mahasiswa.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { 
    header("Location: praktikum_saya.php"); 
    exit(); 
}
$praktikum_id = $_GET['id'];
$mahasiswa_id = $_SESSION['user_id'];

// Ambil info praktikum
$stmt_praktikum = $conn->prepare("SELECT nama_praktikum, kode_praktikum, deskripsi FROM mata_praktikum WHERE id = ?");
$stmt_praktikum->bind_param("i", $praktikum_id);
$stmt_praktikum->execute();
$praktikum = $stmt_praktikum->get_result()->fetch_assoc();

// Ambil semua modul & status laporannya
$stmt_modul = $conn->prepare(
    "SELECT m.id, m.nama_modul, m.deskripsi, m.file_materi, l.file_laporan, l.tanggal_kumpul, l.nilai, l.feedback
     FROM modul m LEFT JOIN laporan l ON m.id = l.modul_id AND l.mahasiswa_id = ?
     WHERE m.praktikum_id = ? ORDER BY m.id ASC"
);
$stmt_modul->bind_param("ii", $mahasiswa_id, $praktikum_id);
$stmt_modul->execute();
$modul_list = $stmt_modul->get_result();

// Hitung statistik
$total_modul = $modul_list->num_rows;
$modul_selesai = 0;
$modul_menunggu = 0;
$rata_rata_nilai = 0;
$total_nilai = 0;
$jumlah_dinilai = 0;

// Reset pointer untuk menghitung stats
$stmt_modul->execute();
$temp_result = $stmt_modul->get_result();
while($temp_modul = $temp_result->fetch_assoc()) {
    if ($temp_modul['file_laporan']) {
        if ($temp_modul['nilai'] !== null) {
            $modul_selesai++;
            $total_nilai += $temp_modul['nilai'];
            $jumlah_dinilai++;
        } else {
            $modul_menunggu++;
        }
    }
}

if ($jumlah_dinilai > 0) {
    $rata_rata_nilai = round($total_nilai / $jumlah_dinilai, 2);
}

// Reset untuk tampilan
$stmt_modul->execute();
$modul_list = $stmt_modul->get_result();
?>

<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 text-white p-8 rounded-2xl shadow-xl mb-8">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <div class="flex items-center mb-4">
                <a href="praktikum_saya.php" class="bg-white bg-opacity-20 hover:bg-opacity-30 p-2 rounded-lg mr-4 transition-all duration-300">
                    <i class="fas fa-arrow-left text-white"></i>
                </a>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2"><?php echo htmlspecialchars($praktikum['nama_praktikum']); ?></h1>
                    <div class="flex items-center space-x-4">
                        <span class="bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo htmlspecialchars($praktikum['kode_praktikum']); ?>
                        </span>
                        <span class="text-blue-100">•</span>
                        <span class="text-blue-100"><?php echo $total_modul; ?> Modul</span>
                    </div>
                </div>
            </div>
            <p class="text-blue-100 text-lg leading-relaxed"><?php echo htmlspecialchars($praktikum['deskripsi']); ?></p>
        </div>
        <div class="hidden md:block">
            <div class="bg-white bg-opacity-20 p-4 rounded-xl">
                <i class="fas fa-flask text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Modul -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl">
                <i class="fas fa-book text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Total</span>
        </div>
        <div class="text-3xl font-bold text-gray-800 mb-2"><?php echo $total_modul; ?></div>
        <div class="text-sm text-gray-600">Total Modul</div>
    </div>

    <!-- Modul Selesai -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl">
                <i class="fas fa-check-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Selesai</span>
        </div>
        <div class="text-3xl font-bold text-gray-800 mb-2"><?php echo $modul_selesai; ?></div>
        <div class="text-sm text-gray-600">Modul Dinilai</div>
    </div>

    <!-- Modul Menunggu -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-3 rounded-xl">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Pending</span>
        </div>
        <div class="text-3xl font-bold text-gray-800 mb-2"><?php echo $modul_menunggu; ?></div>
        <div class="text-sm text-gray-600">Menunggu Nilai</div>
    </div>

    <!-- Rata-rata Nilai -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-3 rounded-xl">
                <i class="fas fa-star text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Rata-rata</span>
        </div>
        <div class="text-3xl font-bold text-gray-800 mb-2"><?php echo $rata_rata_nilai > 0 ? $rata_rata_nilai : '-'; ?></div>
        <div class="text-sm text-gray-600">Nilai Rata-rata</div>
    </div>
</div>

<!-- Progress Bar -->
<div class="bg-white p-6 rounded-2xl shadow-lg mb-8 border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800">Progress Keseluruhan</h3>
        <span class="text-sm font-bold text-blue-600">
            <?php echo $total_modul > 0 ? round(($modul_selesai / $total_modul) * 100) : 0; ?>%
        </span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500" 
             style="width: <?php echo $total_modul > 0 ? ($modul_selesai / $total_modul) * 100 : 0; ?>%">
        </div>
    </div>
</div>

<!-- Daftar Modul -->
<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-tasks mr-3 text-blue-600"></i>
            Daftar Modul & Tugas
        </h3>
        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">
            <?php echo $total_modul; ?> Modul
        </span>
    </div>
    
    <div class="space-y-6">
        <?php $modul_index = 0; ?>
        <?php while($modul = $modul_list->fetch_assoc()): ?>
            <?php $modul_index++; ?>
            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-all duration-300 group">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-2 rounded-lg mr-3">
                                <span class="font-bold text-sm"><?php echo $modul_index; ?></span>
                            </div>
                            <h4 class="font-bold text-lg text-gray-800 group-hover:text-blue-600 transition-colors">
                                <?php echo htmlspecialchars($modul['nama_modul']); ?>
                            </h4>
                        </div>
                        
                        <?php if (!empty($modul['deskripsi'])): ?>
                            <p class="text-gray-600 mb-4 leading-relaxed"><?php echo htmlspecialchars($modul['deskripsi']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($modul['file_materi']): ?>
                        <a href="../uploads/materi/<?php echo htmlspecialchars($modul['file_materi']); ?>" 
                           download 
                           class="bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 font-semibold py-2 px-4 rounded-lg text-sm transition-all duration-300 flex items-center">
                            <i class="fas fa-download mr-2"></i>
                            Unduh Materi
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-clipboard-check mr-2 text-green-500"></i>
                            Status Laporan
                        </h5>
                        
                        <?php if ($modul['file_laporan']): ?>
                            <?php if ($modul['nilai'] !== null): ?>
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>
                                    Sudah Dinilai
                                </span>
                            <?php else: ?>
                                <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu Nilai
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-times mr-1"></i>
                                Belum Dikumpulkan
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($modul['file_laporan']): ?>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <i class="fas fa-file-upload text-green-600 mr-2"></i>
                                    <span class="font-medium text-green-800">Laporan Terkumpul</span>
                                </div>
                                <span class="text-sm text-green-600">
                                    <?php echo date('d M Y, H:i', strtotime($modul['tanggal_kumpul'])); ?>
                                </span>
                            </div>
                            
                            <?php if ($modul['nilai'] !== null): ?>
                                <div class="bg-white border border-green-200 rounded-lg p-4 mt-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-bold text-gray-800">Nilai Akhir:</span>
                                        <span class="text-2xl font-bold text-green-600"><?php echo htmlspecialchars($modul['nilai']); ?></span>
                                    </div>
                                    <?php if (!empty($modul['feedback'])): ?>
                                        <div class="mt-3 pt-3 border-t border-green-200">
                                            <h6 class="font-semibold text-gray-700 mb-2">Feedback:</h6>
                                            <p class="text-gray-600 text-sm"><?php echo htmlspecialchars($modul['feedback']); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-hourglass-half text-yellow-600 mr-2"></i>
                                        <span class="text-yellow-800 font-medium">Laporan sedang dalam proses penilaian</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <form action="kumpul_laporan_action.php" method="post" enctype="multipart/form-data" class="space-y-4">
                                <input type="hidden" name="modul_id" value="<?php echo $modul['id']; ?>">
                                <input type="hidden" name="praktikum_id" value="<?php echo $praktikum_id; ?>">
                                
                                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Pilih File Laporan
                                        </label>
                                        <input type="file" 
                                               name="file_laporan" 
                                               required 
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg">
                                    </div>
                                    <button type="submit" 
                                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center">
                                        <i class="fas fa-upload mr-2"></i>
                                        Kumpulkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Tips Section -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-2xl border border-blue-200">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-lightbulb mr-3 text-yellow-500"></i>
        Tips Mengerjakan Tugas
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-2">
                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                <h4 class="font-semibold text-gray-800">Format File</h4>
            </div>
            <p class="text-sm text-gray-600">Pastikan file laporan dalam format PDF atau DOC untuk hasil terbaik</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-2">
                <i class="fas fa-clock text-green-500 mr-2"></i>
                <h4 class="font-semibold text-gray-800">Deadline</h4>
            </div>
            <p class="text-sm text-gray-600">Kumpulkan tugas sebelum deadline untuk menghindari potongan nilai</p>
        </div>
        
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center mb-2">
                <i class="fas fa-spell-check text-purple-500 mr-2"></i>
                <h4 class="font-semibold text-gray-800">Kualitas</h4>
            </div>
            <p class="text-sm text-gray-600">Periksa kembali laporan sebelum dikumpulkan untuk memastikan kualitas</p>
        </div>
    </div>
</div>

<style>
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

.group:hover .group-hover\:text-blue-600 {
    color: #2563eb;
}
</style>

<?php require_once 'templates/footer_mahasiswa.php'; ?>