<?php
$pageTitle = 'Beri Nilai Laporan';
$activePage = 'laporan';
require_once 'templates/header_asisten.php';

if (!isset($_GET['id'])) {
    header('Location: laporan_masuk.php');
    exit();
}
$id_laporan = $_GET['id'];

// Mengambil data laporan beserta informasi mahasiswa dan modul
$stmt = $conn->prepare(
    "SELECT l.*, u.nama as nama_mahasiswa, m.nama_modul, p.nama_praktikum
     FROM laporan l
     JOIN users u ON l.mahasiswa_id = u.id
     JOIN modul m ON l.modul_id = m.id
     JOIN mata_praktikum p ON m.praktikum_id = p.id
     WHERE l.id = ?"
);
$stmt->bind_param("i", $id_laporan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Laporan tidak ditemukan
    header('Location: laporan_masuk.php');
    exit();
}
$laporan = $result->fetch_assoc();
$stmt->close();
?>

<style>
    .form-container {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .form-header {
        background: linear-gradient(135deg, #2dd4bf 0%, #38b2ac 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .form-input {
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        background: rgba(255,255,255,0.8);
    }
    .form-input:focus {
        border-color: #38b2ac;
        box-shadow: 0 0 0 3px rgba(56,178,172,0.1);
        background: rgba(255,255,255,1);
        transform: translateY(-2px);
    }
    .form-label {
        background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 600;
    }
    .submit-btn {
        background: linear-gradient(135deg, #2dd4bf 0%, #38b2ac 100%);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(56,178,172,0.3);
    }
    .submit-btn:hover {
        background: linear-gradient(135deg, #26a69a 0%, #00897b 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(56,178,172,0.4);
    }
    .back-btn {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
        border-color: #38b2ac;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(56,178,172,0.2);
    }
    .form-section {
        background: rgba(255,255,255,0.6);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
    }
    .download-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .download-btn:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }
</style>

<div class="max-w-4xl mx-auto py-8">
    <div class="mb-6">
        <a href="laporan_masuk.php" class="back-btn inline-flex items-center px-4 py-2 rounded-lg font-medium text-gray-700 hover:text-gray-900 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Laporan Masuk
        </a>
    </div>

    <div class="form-container rounded-2xl p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
            <h1 class="form-header text-3xl font-bold mb-2">Penilaian Laporan</h1>
            <p class="text-gray-600">Berikan nilai dan feedback untuk laporan yang dikumpulkan.</p>
        </div>
        
        <div class="form-section">
            <h2 class="form-label text-lg mb-4">Detail Laporan</h2>
            <div class="space-y-3 text-gray-700">
                <div class="flex items-center"><strong class="w-32">Nama Mahasiswa</strong>: <?php echo htmlspecialchars($laporan['nama_mahasiswa']); ?></div>
                <div class="flex items-center"><strong class="w-32">Praktikum</strong>: <?php echo htmlspecialchars($laporan['nama_praktikum']); ?></div>
                <div class="flex items-center"><strong class="w-32">Modul</strong>: <?php echo htmlspecialchars($laporan['nama_modul']); ?></div>
            </div>
            <a href="../uploads/laporan/<?php echo htmlspecialchars($laporan['file_laporan']); ?>" class="download-btn mt-6 w-full text-white font-bold py-3 px-4 rounded-lg inline-flex items-center justify-center transition-all duration-300 transform hover:scale-105" download>
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh File Laporan
            </a>
        </div>

        <form action="laporan_action.php" method="POST" class="space-y-6">
            <input type="hidden" name="id_laporan" value="<?php echo $laporan['id']; ?>">
            
            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-12v16m-2-16h4m5 16v-4m2 2h-4"></path>
                        </svg>
                    </div>
                    <label for="nilai" class="form-label text-lg">Nilai (0-100)</label>
                </div>
                <input type="number" name="nilai" id="nilai" step="0.01" min="0" max="100" value="<?php echo htmlspecialchars($laporan['nilai']); ?>" class="form-input w-full px-4 py-3 rounded-lg focus:outline-none" placeholder="Contoh: 85.5" required>
            </div>

            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <label for="feedback" class="form-label text-lg">Feedback</label>
                </div>
                <textarea name="feedback" id="feedback" rows="4" class="form-input w-full px-4 py-3 rounded-lg focus:outline-none resize-none" placeholder="Berikan komentar atau masukan untuk perbaikan..."><?php echo htmlspecialchars($laporan['feedback']); ?></textarea>
            </div>

            <div class="pt-6">
                <button type="submit" class="submit-btn w-full py-4 px-6 rounded-lg text-white font-bold text-lg">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Nilai
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Validasi form dan loading state saat submit
document.querySelector('form').addEventListener('submit', function(e) {
    const nilaiInput = document.getElementById('nilai');
    const nilai = parseFloat(nilaiInput.value);
    
    // Validasi input tidak boleh kosong dan harus dalam rentang 0-100
    if (nilaiInput.value.trim() === '') {
        e.preventDefault(); // Mencegah form dikirim
        alert('Nilai wajib diisi!');
        nilaiInput.focus();
        return;
    }
    
    if (isNaN(nilai) || nilai < 0 || nilai > 100) {
        e.preventDefault();
        alert('Mohon masukkan nilai yang valid antara 0 dan 100.');
        nilaiInput.focus();
        return;
    }
    
    // Tambahkan loading state pada tombol
    const submitBtn = document.querySelector('.submit-btn');
    submitBtn.innerHTML = `
        <div class="flex items-center justify-center">
            <svg class="animate-spin w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        </div>
    `;
    submitBtn.disabled = true;
});
</script>

<?php require_once 'templates/footer_asisten.php'; ?>