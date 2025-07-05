<?php
$pageTitle = 'Kelola Modul';
$activePage = 'praktikum'; // Tetap aktif di navigasi praktikum
require_once 'templates/header_asisten.php';

// Pastikan ID praktikum ada di URL
if (!isset($_GET['praktikum_id']) || !is_numeric($_GET['praktikum_id'])) {
    header("Location: praktikum_manage.php");
    exit();
}
$praktikum_id = $_GET['praktikum_id'];

// Ambil nama praktikum untuk judul halaman
$stmt_praktikum = $conn->prepare("SELECT nama_praktikum FROM mata_praktikum WHERE id = ?");
$stmt_praktikum->bind_param("i", $praktikum_id);
$stmt_praktikum->execute();
$result_praktikum = $stmt_praktikum->get_result();
if ($result_praktikum->num_rows === 0) {
    echo "Praktikum tidak ditemukan.";
    require_once 'templates/footer_asisten.php';
    exit();
}
$praktikum = $result_praktikum->fetch_assoc();
$stmt_praktikum->close();

// Ambil semua modul untuk praktikum ini
$stmt_modul = $conn->prepare("SELECT * FROM modul WHERE praktikum_id = ? ORDER BY id ASC");
$stmt_modul->bind_param("i", $praktikum_id);
$stmt_modul->execute();
$result_modul = $stmt_modul->get_result();

?>

<style>
    .container-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }
    
    .header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .header-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 0,100 1000,100"/></svg>');
        background-size: cover;
    }
    
    .breadcrumb-link {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 6px 12px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .breadcrumb-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .add-btn {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        transition: all 0.3s ease;
        border-radius: 12px;
        padding: 12px 24px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
    }
    
    .add-btn:hover {
        background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    }
    
    .status-alert {
        border-radius: 12px;
        padding: 16px 20px;
        margin: 20px 0;
        border: none;
        backdrop-filter: blur(10px);
        animation: slideIn 0.5s ease;
    }
    
    .status-success {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
        border-left: 4px solid #22c55e;
        color: #16a34a;
    }
    
    .status-error {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
        border-left: 4px solid #ef4444;
        color: #dc2626;
    }
    
    .table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 2px solid #e2e8f0;
    }
    
    .table-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table-row:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
        transform: translateY(-1px);
    }
    
    .action-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 0 4px;
    }
    
    .edit-btn {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        box-shadow: 0 2px 10px rgba(251, 191, 36, 0.3);
    }
    
    .edit-btn:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
    }
    
    .delete-btn {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
    }
    
    .delete-btn:hover {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }
    
    .download-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
    }
    
    .download-btn:hover {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .fade-in {
        animation: fadeIn 0.6s ease;
    }
    
    .module-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin: 16px 0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .module-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 8px;
    }
    
    .module-description {
        color: #6b7280;
        margin-bottom: 16px;
        line-height: 1.6;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 4px;
    }
    
    .stats-label {
        opacity: 0.9;
        font-size: 0.9rem;
    }
</style>

<div class="container-card fade-in">
    <!-- Header Section -->
    <div class="header-gradient text-white p-8">
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="flex-1">
                    <a href="praktikum_manage.php" class="breadcrumb-link inline-flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Praktikum
                    </a>
                    <h1 class="text-3xl font-bold mb-2">Manajemen Modul</h1>
                    <p class="text-xl opacity-90"><?php echo htmlspecialchars($praktikum['nama_praktikum']); ?></p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="stats-card">
                        <div class="stats-number"><?php echo $result_modul->num_rows; ?></div>
                        <div class="stats-label">Total Modul</div>
                    </div>
                    <a href="modul_form.php?praktikum_id=<?php echo $praktikum_id; ?>" class="add-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Modul
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-8">
        <!-- Status Messages -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            <div class="status-alert status-success">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold"><?php echo htmlspecialchars($_GET['pesan']); ?></span>
                </div>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
            <div class="status-alert status-error">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold"><?php echo htmlspecialchars($_GET['pesan']); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modules Content -->
        <?php if ($result_modul->num_rows > 0): ?>
            <!-- Desktop Table View -->
            <div class="hidden md:block table-container">
                <table class="w-full">
                    <thead class="table-header">
                        <tr>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Nama Modul
                                </div>
                            </th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    Deskripsi
                                </div>
                            </th>
                            <th class="text-left py-4 px-6 font-semibold text-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    File Materi
                                </div>
                            </th>
                            <th class="text-center py-4 px-6 font-semibold text-gray-700">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($modul = $result_modul->fetch_assoc()): ?>
                        <tr class="table-row">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800"><?php echo htmlspecialchars($modul['nama_modul']); ?></div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-600 max-w-xs truncate"><?php echo htmlspecialchars($modul['deskripsi']); ?></div>
                            </td>
                            <td class="py-4 px-6">
                                <?php if ($modul['file_materi']): ?>
                                    <a href="../uploads/materi/<?php echo htmlspecialchars($modul['file_materi']); ?>" class="download-btn" download>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Unduh
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 italic">Tidak ada file</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="modul_form.php?praktikum_id=<?php echo $praktikum_id; ?>&modul_id=<?php echo $modul['id']; ?>" class="action-btn edit-btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="modul_action.php?action=delete&modul_id=<?php echo $modul['id']; ?>&praktikum_id=<?php echo $praktikum_id; ?>" onclick="return confirm('Anda yakin ingin menghapus modul ini?')" class="action-btn delete-btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden">
                <?php 
                // Reset result untuk mobile view
                $stmt_modul = $conn->prepare("SELECT * FROM modul WHERE praktikum_id = ? ORDER BY id ASC");
                $stmt_modul->bind_param("i", $praktikum_id);
                $stmt_modul->execute();
                $result_modul = $stmt_modul->get_result();
                
                while ($modul = $result_modul->fetch_assoc()): ?>
                <div class="module-card">
                    <div class="module-title"><?php echo htmlspecialchars($modul['nama_modul']); ?></div>
                    <div class="module-description"><?php echo htmlspecialchars($modul['deskripsi']); ?></div>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <?php if ($modul['file_materi']): ?>
                            <a href="../uploads/materi/<?php echo htmlspecialchars($modul['file_materi']); ?>" class="download-btn" download>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Unduh Materi
                            </a>
                        <?php else: ?>
                            <span class="text-gray-400 italic">Tidak ada file</span>
                        <?php endif; ?>
                        
                        <div class="flex gap-2 ml-auto">
                            <a href="modul_form.php?praktikum_id=<?php echo $praktikum_id; ?>&modul_id=<?php echo $modul['id']; ?>" class="action-btn edit-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <a href="modul_action.php?action=delete&modul_id=<?php echo $modul['id']; ?>&praktikum_id=<?php echo $praktikum_id; ?>" onclick="return confirm('Anda yakin ingin menghapus modul ini?')" class="action-btn delete-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Modul</h3>
                <p class="text-gray-500 mb-6">Belum ada modul yang tersedia untuk praktikum ini. Mulai tambahkan modul pertama Anda!</p>
                <a href="modul_form.php?praktikum_id=<?php echo $praktikum_id; ?>" class="add-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Modul Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Auto-hide status messages
document.addEventListener('DOMContentLoaded', function() {
    const statusAlerts = document.querySelectorAll('.status-alert');
    statusAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Smooth animations
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.module-card, .table-row');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        setTimeout(() => {
            element.style.transition = 'all 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php
$stmt_modul->close();
require_once 'templates/footer_asisten.php';
?>