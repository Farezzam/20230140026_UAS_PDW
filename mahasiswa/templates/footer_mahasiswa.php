</div>
</main>

<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white mt-16">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand Section -->
            <div class="col-span-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">SIMPRAK</h3>
                        <p class="text-gray-300 text-sm">Sistem Praktikum</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Memudahkan mahasiswa dalam mengakses materi praktikum dan mengumpulkan tugas dengan sistem yang terintegrasi.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-4">Menu Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="dashboard.php" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
                    <li><a href="praktikum_saya.php" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-book mr-2"></i>Praktikum Saya</a></li>
                    <li><a href="praktikum_katalog.php" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-th-large mr-2"></i>Katalog Praktikum</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-span-1">
                <h4 class="text-lg font-semibold mb-4">Dukungan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-question-circle mr-2"></i>Bantuan</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-envelope mr-2"></i>Kontak</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-file-alt mr-2"></i>Panduan</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                &copy; <?php echo date("Y"); ?> SIMPRAK - Sistem Informasi Manajemen Praktikum. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-500 to-purple-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 pointer-events-none">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
// Back to Top functionality
window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTopBtn.style.opacity = '1';
        backToTopBtn.style.pointerEvents = 'auto';
    } else {
        backToTopBtn.style.opacity = '0';
        backToTopBtn.style.pointerEvents = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Add smooth scrolling to all anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>

</body>
</html>