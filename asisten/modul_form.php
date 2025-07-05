<?php
$pageTitle = 'Form Modul';
$activePage = 'praktikum';
require_once 'templates/header_asisten.php';

// Pastikan ID praktikum ada
if (!isset($_GET['praktikum_id'])) {
    header("Location: praktikum_manage.php");
    exit();
}
$praktikum_id = $_GET['praktikum_id'];
$modul_id = $_GET['modul_id'] ?? null;

// Default data
$data = ['id' => '', 'nama_modul' => '', 'deskripsi' => '', 'file_materi' => ''];

// Jika ini adalah mode edit, ambil data dari DB
if ($modul_id) {
    $stmt = $conn->prepare("SELECT * FROM modul WHERE id = ? AND praktikum_id = ?");
    $stmt->bind_param("ii", $modul_id, $praktikum_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
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
    
    .file-input {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 2px dashed #cbd5e0;
        transition: all 0.3s ease;
    }
    
    .file-input:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
    }
    
    .current-file {
        background: linear-gradient(135deg, #e6fffa 0%, #b2f5ea 100%);
        border: 1px solid #38b2ac;
        border-radius: 8px;
        padding: 12px 16px;
        margin-top: 8px;
    }
    
    .icon-wrapper {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        padding: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
    }
    
    .form-section {
        background: rgba(255,255,255,0.6);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
    }
    
    .animated-border {
        position: relative;
        overflow: hidden;
    }
    
    .animated-border::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #667eea, transparent);
        transition: left 0.5s;
    }
    
    .animated-border:hover::before {
        left: 100%;
    }
</style>

<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="modul_manage.php?praktikum_id=<?php echo $praktikum_id; ?>" class="back-btn inline-flex items-center px-4 py-2 rounded-lg font-medium text-gray-700 hover:text-gray-900 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Modul
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-container rounded-2xl p-8 animated-border">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="icon-wrapper w-16 h-16 mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h1 class="form-header text-3xl font-bold mb-2">
                <?php echo $modul_id ? 'Edit' : 'Tambah'; ?> Modul
            </h1>
            <p class="text-gray-600">
                <?php echo $modul_id ? 'Perbarui informasi modul praktikum' : 'Buat modul praktikum baru'; ?>
            </p>
        </div>

        <!-- Form -->
        <form action="modul_action.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="praktikum_id" value="<?php echo $praktikum_id; ?>">
            <input type="hidden" name="modul_id" value="<?php echo $data['id']; ?>">
            <input type="hidden" name="action" value="<?php echo $modul_id ? 'update' : 'create'; ?>">
            
            <!-- Nama Modul Section -->
            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <label for="nama_modul" class="form-label text-lg">Nama Modul</label>
                </div>
                <input type="text" 
                       name="nama_modul" 
                       id="nama_modul"
                       value="<?php echo htmlspecialchars($data['nama_modul']); ?>" 
                       class="form-input w-full px-4 py-3 rounded-lg focus:outline-none"
                       placeholder="Masukkan nama modul praktikum"
                       required>
            </div>

            <!-- Deskripsi Section -->
            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <label for="deskripsi" class="form-label text-lg">Deskripsi</label>
                </div>
                <textarea name="deskripsi" 
                          id="deskripsi"
                          rows="4" 
                          class="form-input w-full px-4 py-3 rounded-lg focus:outline-none resize-none"
                          placeholder="Jelaskan detail tentang modul ini..."><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
            </div>

            <!-- File Materi Section -->
            <div class="form-section">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                    </div>
                    <label for="file_materi" class="form-label text-lg">File Materi</label>
                </div>
                
                <div class="file-input p-6 rounded-lg text-center">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <input type="file" 
                           name="file_materi" 
                           id="file_materi"
                           class="hidden"
                           accept=".pdf,.doc,.docx"
                           onchange="updateFileName(this)">
                    <label for="file_materi" class="cursor-pointer">
                        <span class="text-blue-600 hover:text-blue-800 font-medium">Pilih File</span>
                        <span class="text-gray-500"> atau drag & drop file di sini</span>
                    </label>
                    <p class="text-sm text-gray-500 mt-2">Format: PDF, DOC, DOCX (Maksimal 10MB)</p>
                    <p id="fileName" class="text-sm text-blue-600 mt-2 hidden"></p>
                </div>
                
                <?php if ($data['file_materi']): ?>
                <div class="current-file mt-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-teal-800">
                            <strong>File saat ini:</strong> <?php echo htmlspecialchars($data['file_materi']); ?>
                        </span>
                    </div>
                    <p class="text-xs text-teal-600 mt-1">Biarkan kosong jika tidak ingin mengubah file</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button type="submit" class="submit-btn w-full py-4 px-6 rounded-lg text-white font-bold text-lg transition-all duration-300">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <?php echo $modul_id ? 'Perbarui' : 'Simpan'; ?> Modul
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        fileName.textContent = `File dipilih: ${input.files[0].name}`;
        fileName.classList.remove('hidden');
    } else {
        fileName.classList.add('hidden');
    }
}

// Drag and drop functionality
const fileInput = document.getElementById('file_materi');
const fileInputArea = document.querySelector('.file-input');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileInputArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileInputArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileInputArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    fileInputArea.classList.add('border-blue-500', 'bg-blue-50');
}

function unhighlight(e) {
    fileInputArea.classList.remove('border-blue-500', 'bg-blue-50');
}

fileInputArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        fileInput.files = files;
        updateFileName(fileInput);
    }
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const namaModul = document.getElementById('nama_modul').value.trim();
    
    if (!namaModul) {
        e.preventDefault();
        alert('Nama modul harus diisi!');
        document.getElementById('nama_modul').focus();
        return;
    }
    
    // Add loading state to button
    const submitBtn = document.querySelector('.submit-btn');
    submitBtn.innerHTML = `
        <div class="flex items-center justify-center">
            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
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