<?php
$pageTitle = 'Katalog Praktikum';
$activePage = 'katalog';
require_once 'templates/header_mahasiswa.php';

$mahasiswa_id = $_SESSION['user_id'];
$stmt_pendaftaran = $conn->prepare("SELECT praktikum_id FROM pendaftaran WHERE mahasiswa_id = ?");
$stmt_pendaftaran->bind_param('i', $mahasiswa_id);
$stmt_pendaftaran->execute();
$result_pendaftaran = $stmt_pendaftaran->get_result();
$praktikum_terdaftar_ids = array_column($result_pendaftaran->fetch_all(MYSQLI_ASSOC), 'praktikum_id');

$result = $conn->query("SELECT * FROM mata_praktikum ORDER BY nama_praktikum ASC");
$total_praktikum = $result->num_rows;
$praktikum_terdaftar = count($praktikum_terdaftar_ids);
$praktikum_tersedia = $total_praktikum - $praktikum_terdaftar;
?>

<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-r from-green-600 via-blue-600 to-purple-600 text-white rounded-2xl shadow-2xl mb-8">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-green-600/30 to-purple-600/30"></div>
    <div class="relative px-8 py-12 md:py-16">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Katalog Praktikum
                <span class="block text-yellow-300">Pilih & Daftar Sekarang!</span>
            </h1>
            <p class="text-xl md:text-2xl opacity-90 mb-6 leading-relaxed">
                Temukan berbagai mata praktikum yang tersedia dan daftarkan diri Anda.
                <span class="block text-green-200">Kembangkan keahlian dan raih prestasi terbaik!</span>
            </p>
            <div class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="flex items-center space-x-4 text-lg">
                    <div class="flex items-center bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-book mr-2"></i>
                        <span><?php echo $total_praktikum; ?> Total Praktikum</span>
                    </div>
                    <div class="flex items-center bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span><?php echo $praktikum_terdaftar; ?> Terdaftar</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white bg-opacity-10 rounded-full -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-yellow-400 bg-opacity-20 rounded-full -ml-24 -mb-24"></div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Praktikum -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-xl">
                <i class="fas fa-book text-white text-2xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Total</span>
        </div>
        <div class="text-4xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
            <?php echo $total_praktikum; ?>
        </div>
        <div class="text-lg text-gray-600 font-medium">Praktikum Tersedia</div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <i class="fas fa-graduation-cap text-blue-500 mr-1"></i>
            <span>Siap untuk diikuti</span>
        </div>
    </div>

    <!-- Praktikum Terdaftar -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-xl">
                <i class="fas fa-check-circle text-white text-2xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Aktif</span>
        </div>
        <div class="text-4xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
            <?php echo $praktikum_terdaftar; ?>
        </div>
        <div class="text-lg text-gray-600 font-medium">Sudah Terdaftar</div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <i class="fas fa-user-check text-green-500 mr-1"></i>
            <span>Praktikum diikuti</span>
        </div>
    </div>

    <!-- Praktikum Tersedia -->
    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
        <div class="flex items-center justify-between mb-4">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-3 rounded-xl">
                <i class="fas fa-plus-circle text-white text-2xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Baru</span>
        </div>
        <div class="text-4xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">
            <?php echo $praktikum_tersedia; ?>
        </div>
        <div class="text-lg text-gray-600 font-medium">Bisa Didaftar</div>
        <div class="mt-4 flex items-center text-sm text-gray-500">
            <i class="fas fa-arrow-right text-purple-500 mr-1"></i>
            <span>Siap mendaftar</span>
        </div>
    </div>
</div>

<!-- Status Messages -->
<?php if (isset($_GET['status'])): ?>
<div class="mb-6">
    <div class="p-4 rounded-xl border-l-4 <?php echo $_GET['status'] == 'sukses' ? 'bg-green-50 border-green-400' : 'bg-red-50 border-red-400'; ?>">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="<?php echo $_GET['status'] == 'sukses' ? 'fas fa-check-circle text-green-500' : 'fas fa-exclamation-circle text-red-500'; ?> text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium <?php echo $_GET['status'] == 'sukses' ? 'text-green-800' : 'text-red-800'; ?>">
                    <?php echo htmlspecialchars($_GET['pesan']); ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Search and Filter Section -->
<div class="bg-white p-6 rounded-2xl shadow-lg mb-8 border border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0 flex items-center">
            <i class="fas fa-search mr-3 text-blue-600"></i>
            Cari Praktikum
        </h3>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Cari praktikum..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select id="filterSelect" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="all">Semua Praktikum</option>
                <option value="available">Bisa Didaftar</option>
                <option value="registered">Sudah Terdaftar</option>
            </select>
        </div>
    </div>
</div>

<!-- Katalog Cards -->
<div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-th-large mr-3 text-purple-600"></i>
            Daftar Praktikum
        </h2>
        <div class="flex items-center space-x-2">
            <button id="gridView" class="p-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors">
                <i class="fas fa-th-large"></i>
            </button>
            <button id="listView" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    
    <div id="praktikumGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php 
        $result->data_seek(0); // Reset result pointer
        while($praktikum = $result->fetch_assoc()): 
            $is_registered = in_array($praktikum['id'], $praktikum_terdaftar_ids);
        ?>
            <div class="praktikum-card border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 bg-gradient-to-br from-white to-gray-50" 
                 data-name="<?php echo strtolower($praktikum['nama_praktikum']); ?>" 
                 data-status="<?php echo $is_registered ? 'registered' : 'available'; ?>">
                
                <!-- Header with Icon -->
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl">
                        <i class="fas fa-flask text-white text-2xl"></i>
                    </div>
                    <div class="flex items-center space-x-2">
                        <?php if ($is_registered): ?>
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-medium">
                                <i class="fas fa-check mr-1"></i>Terdaftar
                            </span>
                        <?php else: ?>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">
                                <i class="fas fa-plus mr-1"></i>Tersedia
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 line-clamp-2">
                        <?php echo htmlspecialchars($praktikum['nama_praktikum']); ?>
                    </h3>
                    <p class="text-sm text-blue-600 font-medium mb-3 bg-blue-50 px-3 py-1 rounded-full inline-block">
                        <?php echo htmlspecialchars($praktikum['kode_praktikum']); ?>
                    </p>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                        <?php echo htmlspecialchars($praktikum['deskripsi']); ?>
                    </p>
                </div>

                <!-- Action Button -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <?php if ($is_registered): ?>
                        <div class="flex items-center justify-between">
                            <button class="w-full bg-green-100 text-green-600 py-3 px-4 rounded-xl font-semibold cursor-not-allowed flex items-center justify-center" disabled>
                                <i class="fas fa-check-circle mr-2"></i>
                                Sudah Terdaftar
                            </button>
                        </div>
                    <?php else: ?>
                        <form action="daftar_praktikum_action.php" method="POST">
                            <input type="hidden" name="praktikum_id" value="<?php echo $praktikum['id']; ?>">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center group">
                                <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform"></i>
                                Daftar Sekarang
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="text-center py-12 hidden">
        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-gray-400 text-2xl"></i>
        </div>
        <h4 class="text-lg font-semibold text-gray-600 mb-2">Tidak ada praktikum ditemukan</h4>
        <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter yang digunakan</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-2xl border border-gray-200">
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-rocket mr-3 text-orange-600"></i>
        Aksi Cepat
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="praktikum_saya.php" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-blue-100 p-3 rounded-lg mr-4 group-hover:bg-blue-200 transition-colors">
                <i class="fas fa-book text-blue-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Praktikum Saya</h4>
                <p class="text-sm text-gray-600">Lihat praktikum yang diikuti</p>
            </div>
        </a>
        
        <a href="dashboard.php" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-green-100 p-3 rounded-lg mr-4 group-hover:bg-green-200 transition-colors">
                <i class="fas fa-tachometer-alt text-green-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Dashboard</h4>
                <p class="text-sm text-gray-600">Kembali ke dashboard</p>
            </div>
        </a>
        
        <a href="#" class="flex items-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 group">
            <div class="bg-purple-100 p-3 rounded-lg mr-4 group-hover:bg-purple-200 transition-colors">
                <i class="fas fa-question-circle text-purple-600"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Bantuan</h4>
                <p class="text-sm text-gray-600">Panduan pendaftaran</p>
            </div>
        </a>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.praktikum-card {
    animation: fadeIn 0.5s ease-in-out;
}

.praktikum-card:hover {
    background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
}

#praktikumGrid.list-view {
    display: block;
}

#praktikumGrid.list-view .praktikum-card {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    padding: 1.5rem;
}

#praktikumGrid.list-view .praktikum-card > div:first-child {
    flex-shrink: 0;
    margin-right: 1rem;
}

#praktikumGrid.list-view .praktikum-card > div:last-child {
    flex-shrink: 0;
    margin-left: 1rem;
    margin-top: 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');
    const praktikumCards = document.querySelectorAll('.praktikum-card');
    const emptyState = document.getElementById('emptyState');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const praktikumGrid = document.getElementById('praktikumGrid');

    // Search and Filter functionality
    function filterPraktikum() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value;
        let visibleCount = 0;

        praktikumCards.forEach(card => {
            const name = card.getAttribute('data-name');
            const status = card.getAttribute('data-status');
            
            const matchesSearch = name.includes(searchTerm);
            const matchesFilter = filterValue === 'all' || status === filterValue;
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    // View toggle functionality
    function toggleView(view) {
        if (view === 'grid') {
            praktikumGrid.classList.remove('list-view');
            praktikumGrid.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-6');
            gridView.classList.add('bg-blue-100', 'text-blue-600');
            gridView.classList.remove('text-gray-400');
            listView.classList.remove('bg-blue-100', 'text-blue-600');
            listView.classList.add('text-gray-400');
        } else {
            praktikumGrid.classList.add('list-view');
            praktikumGrid.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-6');
            listView.classList.add('bg-blue-100', 'text-blue-600');
            listView.classList.remove('text-gray-400');
            gridView.classList.remove('bg-blue-100', 'text-blue-600');
            gridView.classList.add('text-gray-400');
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterPraktikum);
    filterSelect.addEventListener('change', filterPraktikum);
    gridView.addEventListener('click', () => toggleView('grid'));
    listView.addEventListener('click', () => toggleView('list'));

    // Add hover effects
    praktikumCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>

<?php require_once 'templates/footer_mahasiswa.php'; ?>