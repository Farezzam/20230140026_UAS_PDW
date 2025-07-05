<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once 'templates/header_asisten.php';

// Menghitung Total Modul
$total_modul = $conn->query("SELECT COUNT(*) as total FROM modul")->fetch_assoc()['total'];

// Menghitung Total Laporan Masuk
$total_laporan = $conn->query("SELECT COUNT(*) as total FROM laporan")->fetch_assoc()['total'];

// Menghitung Laporan Belum Dinilai
$laporan_pending = $conn->query("SELECT COUNT(*) as total FROM laporan WHERE nilai IS NULL")->fetch_assoc()['total'];

// Mengambil Aktivitas Laporan Terbaru
$stmt_aktivitas = $conn->prepare(
    "SELECT u.nama, m.nama_modul, l.tanggal_kumpul
     FROM laporan l
     JOIN users u ON l.mahasiswa_id = u.id
     JOIN modul m ON l.modul_id = m.id
     ORDER BY l.tanggal_kumpul DESC LIMIT 5"
);
$stmt_aktivitas->execute();
$aktivitas_terbaru = $stmt_aktivitas->get_result();
?>

<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .stat-card:hover::before {
        opacity: 1;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .stat-card-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    }
    
    .stat-card-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .stat-card-yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .activity-item {
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 8px;
    }
    
    .activity-item:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        transform: translateX(5px);
    }
    
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    .icon-wrapper {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    .card-shadow {
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);
    }
</style>

<!-- Welcome Section -->
<div class="welcome-section text-white relative z-10">
    <div class="flex items-center">
        <div class="icon-wrapper">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h1>
            <p class="text-white opacity-90">Kelola praktikum dan laporan mahasiswa dengan mudah</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Modul Card -->
    <div class="stat-card stat-card-blue text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="icon-wrapper">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-white opacity-80 mb-1">Total Modul Diajarkan</p>
                <p class="text-3xl font-bold"><?php echo $total_modul; ?></p>
            </div>
        </div>
    </div>

    <!-- Total Laporan Card -->
    <div class="stat-card stat-card-green text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="icon-wrapper">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-white opacity-80 mb-1">Total Laporan Masuk</p>
                <p class="text-3xl font-bold"><?php echo $total_laporan; ?></p>
            </div>
        </div>
    </div>

    <!-- Laporan Pending Card -->
    <div class="stat-card stat-card-yellow text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="icon-wrapper">
                <svg class="w-8 h-8 text-white pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-white opacity-80 mb-1">Laporan Belum Dinilai</p>
                <p class="text-3xl font-bold"><?php echo $laporan_pending; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Activity Section -->
<div class="bg-white p-6 rounded-lg shadow-lg card-shadow">
    <div class="flex items-center mb-6">
        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-xl font-bold text-gray-800">Aktivitas Laporan Terbaru</h3>
            <p class="text-sm text-gray-600">Pantau aktivitas mahasiswa secara real-time</p>
        </div>
    </div>

    <div class="space-y-2">
        <?php if ($aktivitas_terbaru->num_rows > 0): ?>
            <?php while ($aktivitas = $aktivitas_terbaru->fetch_assoc()): ?>
                <div class="activity-item border-l-4 border-blue-500 pl-4">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">
                                <span class="text-blue-600 font-bold"><?php echo htmlspecialchars($aktivitas['nama']); ?></span> 
                                mengumpulkan laporan untuk 
                                <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($aktivitas['nama_modul']); ?></span>
                            </p>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php echo date('d M Y, H:i', strtotime($aktivitas['tanggal_kumpul'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada aktivitas terbaru</p>
                <p class="text-gray-400 text-sm mt-2">Aktivitas mahasiswa akan muncul di sini</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="praktikum_manage.php" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Kelola Praktikum</p>
                <p class="text-sm text-gray-600">Atur modul praktikum</p>
            </div>
        </div>
    </a>

    <a href="laporan_masuk.php" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Laporan Masuk</p>
                <p class="text-sm text-gray-600">Review dan nilai laporan</p>
            </div>
        </div>
    </a>

    <a href="user_manage.php" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:transform hover:scale-105">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Kelola Pengguna</p>
                <p class="text-sm text-gray-600">Manajemen user</p>
            </div>
        </div>
    </a>

    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Statistik</p>
                <p class="text-sm text-gray-600">Lihat performa sistem</p>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'templates/footer_asisten.php';
?>