<?php
$pageTitle = 'Kelola Praktikum';
$activePage = 'praktikum';
require_once 'templates/header_asisten.php';

// --- LOGIKA BARU UNTUK STATISTIK ---
// Menghitung Total Mata Praktikum
$total_praktikum = $conn->query("SELECT COUNT(*) as total FROM mata_praktikum")->fetch_assoc()['total'];
// Menghitung Total Modul
$total_modul = $conn->query("SELECT COUNT(*) as total FROM modul")->fetch_assoc()['total'];

$result = $conn->query("SELECT mp.id, mp.kode_praktikum, mp.nama_praktikum, COUNT(m.id) as jumlah_modul 
                        FROM mata_praktikum mp
                        LEFT JOIN modul m ON mp.id = m.praktikum_id
                        GROUP BY mp.id, mp.kode_praktikum, mp.nama_praktikum
                        ORDER BY mp.id DESC");
?>

<style>
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
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
        background: rgba(255, 255, 255, 0.2);
        padding: 1rem;
        border-radius: 16px;
        margin-right: 1.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .stat-card {
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }
    
    .stat-card-blue {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stat-card-green {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    
    .stat-card-purple {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    
    .stat-card-orange {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    }
    
    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    }
    
    .praktikum-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .praktikum-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .praktikum-card:hover::before {
        transform: scaleX(1);
    }
    
    .praktikum-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }
    
    .kode-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .modul-count {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
    }
    
    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }
    
    .action-btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn-modul {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-modul:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    }
    
    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .btn-add::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-add:hover::before {
        left: 100%;
    }
    
    .btn-add:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
    }
    
    .grid-container {
        display: grid;
        gap: 1.5rem;
    }
    
    @media (min-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }
    
    .empty-state svg {
        width: 4rem;
        height: 4rem;
        margin: 0 auto 1rem;
        color: #d1d5db;
    }
    
    .search-section {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .search-input {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        width: 100%;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>

<div class="welcome-section text-white relative z-10 mb-8 fade-in">
    <div class="flex items-center">
        <div class="icon-wrapper">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-bold mb-2">Manajemen Praktikum</h1>
            <p class="text-white opacity-90 text-lg">Kelola mata praktikum dan modul dengan mudah dan efisien</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="stat-card stat-card-blue text-white p-6 rounded-lg shadow-lg fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-white opacity-80 mb-1">Total Mata Praktikum</p>
                <p class="text-4xl font-bold"><?php echo $total_praktikum; ?></p>
            </div>
            <div class="text-white opacity-50">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="stat-card stat-card-green text-white p-6 rounded-lg shadow-lg fade-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-white opacity-80 mb-1">Total Modul</p>
                <p class="text-4xl font-bold"><?php echo $total_modul; ?></p>
            </div>
            <div class="text-white opacity-50">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="content-card p-6 sm:p-8 fade-in">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Daftar Mata Praktikum</h2>
            <p class="text-gray-600">Kelola semua mata praktikum yang tersedia</p>
        </div>
        <a href="praktikum_form.php" class="btn-add">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Tambah Praktikum</span>
        </a>
    </div>

    <div class="search-section">
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari praktikum berdasarkan kode atau nama..." class="search-input">
        </div>
    </div>

    <div class="grid-container" id="praktikumContainer">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="praktikum-card fade-in" data-praktikum="<?php echo strtolower($row['kode_praktikum'] . ' ' . $row['nama_praktikum']); ?>">
                <div class="flex flex-col h-full">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="kode-badge mb-3">
                                <?php echo htmlspecialchars($row['kode_praktikum']); ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">
                                <?php echo htmlspecialchars($row['nama_praktikum']); ?>
                            </h3>
                        </div>
                        <div class="modul-count">
                            <?php echo $row['jumlah_modul']; ?> Modul
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mt-auto">
                        <a href="modul_manage.php?praktikum_id=<?php echo $row['id']; ?>" class="action-btn btn-modul">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Modul</span>
                        </a>
                        <a href="praktikum_form.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z"></path>
                            </svg>
                            <span>Edit</span>
                        </a>
                        <a href="praktikum_action.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus praktikum ini beserta semua modulnya?')" class="action-btn btn-delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Hapus</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full">
                <div class="empty-state">
                    <svg class="mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada praktikum</h3>
                    <p class="text-gray-500 mb-4">Mulai dengan menambahkan mata praktikum pertama Anda</p>
                    <a href="praktikum_form.php" class="btn-add">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Tambah Praktikum</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const praktikumCards = document.querySelectorAll('[data-praktikum]');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        praktikumCards.forEach(card => {
            const praktikumData = card.getAttribute('data-praktikum');
            if (praktikumData.includes(searchTerm)) {
                card.style.display = 'block';
                card.classList.add('fade-in');
            } else {
                card.style.display = 'none';
                card.classList.remove('fade-in');
            }
        });
    });
    
    // Add pulse animation to stats on hover
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const number = this.querySelector('.text-4xl');
            number.classList.add('pulse');
        });
        
        card.addEventListener('mouseleave', function() {
            const number = this.querySelector('.text-4xl');
            number.classList.remove('pulse');
        });
    });
});
</script>

<?php require_once 'templates/footer_asisten.php'; ?>