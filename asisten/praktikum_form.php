<?php
$pageTitle = 'Form Praktikum';
$activePage = 'praktikum';
require_once 'templates/header_asisten.php';

// Menentukan apakah ini mode edit atau tambah
$is_edit_mode = isset($_GET['id']) && !empty($_GET['id']);
$praktikum_id = $is_edit_mode ? $_GET['id'] : null;

// Data default untuk form
$data = ['id' => '', 'kode_praktikum' => '', 'nama_praktikum' => '', 'deskripsi' => ''];

// Jika mode edit, ambil data praktikum dari database
if ($is_edit_mode) {
    $stmt = $conn->prepare("SELECT * FROM mata_praktikum WHERE id = ?");
    $stmt->bind_param("i", $praktikum_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        // Jika ID tidak ditemukan, kembali ke halaman utama
        header("Location: praktikum_manage.php");
        exit();
    }
    $stmt->close();
}
?>

<style>
    .form-container {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
    }
    .submit-btn:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102,126,234,0.4);
    }
    .back-btn {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102,126,234,0.2);
    }
    .form-section {
        background: rgba(255,255,255,0.6);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
    }
</style>

<div class="max-w-4xl mx-auto py-8">
    <div class="mb-6">
        <a href="praktikum_manage.php" class="back-btn inline-flex items-center px-4 py-2 rounded-lg font-medium text-gray-700 hover:text-gray-900 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Praktikum
        </a>
    </div>

    <div class="form-container rounded-2xl p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h1 class="form-header text-3xl font-bold mb-2">
                <?php echo $is_edit_mode ? 'Edit' : 'Tambah'; ?> Praktikum
            </h1>
            <p class="text-gray-600">
                <?php echo $is_edit_mode ? 'Perbarui detail mata praktikum yang sudah ada' : 'Buat mata praktikum baru untuk dikelola'; ?>
            </p>
        </div>

        <form action="praktikum_action.php" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <input type="hidden" name="action" value="<?php echo $is_edit_mode ? 'update' : 'create'; ?>">
            
            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                    </div>
                    <label for="kode_praktikum" class="form-label text-lg">Kode Praktikum</label>
                </div>
                <input type="text" 
                       name="kode_praktikum" 
                       id="kode_praktikum"
                       value="<?php echo htmlspecialchars($data['kode_praktikum']); ?>" 
                       class="form-input w-full px-4 py-3 rounded-lg focus:outline-none"
                       placeholder="Contoh: EL2101"
                       required>
            </div>

            <div class="form-section">
                <div class="flex items-center mb-4">
                     <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <label for="nama_praktikum" class="form-label text-lg">Nama Praktikum</label>
                </div>
                <input type="text" 
                       name="nama_praktikum" 
                       id="nama_praktikum"
                       value="<?php echo htmlspecialchars($data['nama_praktikum']); ?>" 
                       class="form-input w-full px-4 py-3 rounded-lg focus:outline-none"
                       placeholder="Contoh: Praktikum Rangkaian Elektrik"
                       required>
            </div>

            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <label for="deskripsi" class="form-label text-lg">Deskripsi Singkat</label>
                </div>
                <textarea name="deskripsi" 
                          id="deskripsi"
                          rows="4" 
                          class="form-input w-full px-4 py-3 rounded-lg focus:outline-none resize-none"
                          placeholder="Jelaskan secara singkat tentang praktikum ini..."><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
            </div>

            <div class="pt-6">
                <button type="submit" class="submit-btn w-full py-4 px-6 rounded-lg text-white font-bold text-lg">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php echo $is_edit_mode ? 'Perbarui Praktikum' : 'Simpan Praktikum'; ?>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Validasi form dan loading state saat submit
document.querySelector('form').addEventListener('submit', function(e) {
    const kodePraktikum = document.getElementById('kode_praktikum').value.trim();
    const namaPraktikum = document.getElementById('nama_praktikum').value.trim();
    
    // Validasi input tidak boleh kosong
    if (!kodePraktikum || !namaPraktikum) {
        e.preventDefault(); // Mencegah form dikirim
        alert('Kode dan Nama Praktikum wajib diisi!');
        
        if (!kodePraktikum) {
            document.getElementById('kode_praktikum').focus();
        } else {
            document.getElementById('nama_praktikum').focus();
        }
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