<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - SIMPRAK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar-brand {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,1000 1000,800 1000,1000"/></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 32px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-custom {
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            border-radius: 50px;
            padding: 12px 32px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: white;
            color: white;
        }

        .stats-mini {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
        }

        .stats-mini h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffd700;
            margin-bottom: 0.25rem;
        }

        .stats-mini p {
            font-size: 0.9rem;
            margin: 0;
            opacity: 0.8;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #e9ecef;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        .feature-icon.blue {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .feature-icon.green {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .feature-icon.yellow {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .feature-text {
            color: #6b7280;
            line-height: 1.6;
            margin: 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 3rem;
        }

        .step-card {
            text-align: center;
            padding: 1.5rem;
        }

        .step-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin: 0 auto 1rem;
        }

        .step-number.blue { background: #667eea; }
        .step-number.green { background: #22c55e; }
        .step-number.yellow { background: #f59e0b; }
        .step-number.purple { background: #8b5cf6; }

        .step-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .step-text {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }

        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 4rem 0;
            color: white;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.8;
            margin: 0;
        }

        .cta-section {
            padding: 4rem 0;
            background: #f8f9fa;
        }

        .cta-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-text {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating-element:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-element:nth-child(3) {
            animation-delay: -4s;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.25rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fs-3" href="#">
            <i class="fas fa-graduation-cap me-2"></i>SIMPRAK
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark" href="#fitur">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark" href="#cara-kerja">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark" href="#tentang">Tentang</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-primary-custom text-white" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section text-white">
    <!-- Floating Elements -->
    <div class="floating-element" style="top: 20%; right: 10%; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div class="floating-element" style="top: 60%; left: 8%; width: 80px; height: 80px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div class="floating-element" style="bottom: 20%; right: 15%; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    
    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-3">
                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill fw-medium">
                        <i class="fas fa-star me-1"></i>Sistem Terdepan
                    </span>
                </div>
                <h1 class="hero-title">
                    Selamat Datang di
                    <span class="text-warning">SIMPRAK</span>
                </h1>
                <p class="hero-subtitle">
                    Sistem Informasi Pengumpulan Tugas Praktikum yang memudahkan mahasiswa mengelola tugas akademik dengan efisien dan modern.
                </p>
                
                <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
                    <a href="login.php" class="btn btn-primary-custom text-white">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Masuk ke Akun
                    </a>
                    <a href="register.php" class="btn btn-outline-custom">
                        <i class="fas fa-user-plus me-2"></i>
                        Daftar Sekarang
                    </a>
                </div>
                
                <!-- Mini Stats -->
                <div class="row g-3">
                    <div class="col-4">
                        <div class="stats-mini">
                            <h4>500+</h4>
                            <p>Mahasiswa</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stats-mini">
                            <h4>50+</h4>
                            <p>Praktikum</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stats-mini">
                            <h4>95%</h4>
                            <p>Kepuasan</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="text-center mt-5 mt-lg-0">
                    <div class="position-relative d-inline-block">
                        <div class="bg-white p-4 rounded-4 shadow-lg">
                            <i class="fas fa-laptop-code" style="font-size: 5rem; color: #667eea;"></i>
                        </div>
                        <div class="position-absolute top-0 end-0 bg-warning p-2 rounded-circle shadow-sm" style="transform: translate(20px, -20px);">
                            <i class="fas fa-star text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="fitur" class="py-5">
    <div class="container">
        <h2 class="section-title">Fitur Unggulan</h2>
        <p class="section-subtitle">Kenapa mahasiswa memilih SIMPRAK?</p>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon blue">
                        <i class="fas fa-upload"></i>
                    </div>
                    <h4 class="feature-title">Upload Mudah</h4>
                    <p class="feature-text">Kumpulkan tugas praktikum dengan mudah melalui interface yang intuitif dan responsif.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon green">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="feature-title">Tracking Progress</h4>
                    <p class="feature-text">Pantau progress tugas dan nilai secara real-time dengan dashboard yang informatif.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon yellow">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h4 class="feature-title">Notifikasi</h4>
                    <p class="feature-text">Dapatkan notifikasi instan ketika tugas dinilai atau ada pengumuman penting.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="cara-kerja" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Cara Kerja</h2>
        <p class="section-subtitle">Langkah mudah menggunakan SIMPRAK</p>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="step-card">
                    <div class="step-number blue">1</div>
                    <h5 class="step-title">Daftar Akun</h5>
                    <p class="step-text">Buat akun baru dengan email dan data pribadi Anda</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="step-card">
                    <div class="step-number green">2</div>
                    <h5 class="step-title">Pilih Praktikum</h5>
                    <p class="step-text">Daftar ke praktikum sesuai mata kuliah yang diambil</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="step-card">
                    <div class="step-number yellow">3</div>
                    <h5 class="step-title">Kerjakan Tugas</h5>
                    <p class="step-text">Kerjakan dan upload tugas sesuai deadline</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="step-card">
                    <div class="step-number purple">4</div>
                    <h5 class="step-title">Dapatkan Nilai</h5>
                    <p class="step-text">Pantau nilai dan feedback dari dosen</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-number">500+</div>
                    <p class="stat-label">Mahasiswa Aktif</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-book stat-icon"></i>
                    <div class="stat-number">50+</div>
                    <p class="stat-label">Praktikum</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-tasks stat-icon"></i>
                    <div class="stat-number">1000+</div>
                    <p class="stat-label">Tugas Dikumpulkan</p>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-star stat-icon"></i>
                    <div class="stat-number">95%</div>
                    <p class="stat-label">Tingkat Kepuasan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section id="tentang" class="cta-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="cta-title">Siap Memulai Perjalanan Akademik Anda?</h2>
                <p class="cta-text">
                    Bergabunglah dengan ribuan mahasiswa yang telah merasakan kemudahan mengelola tugas praktikum dengan SIMPRAK. Mulai sekarang dan rasakan perbedaannya!
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="register.php" class="btn btn-primary-custom text-white">
                        <i class="fas fa-rocket me-2"></i>
                        Mulai Sekarang
                    </a>
                    <a href="login.php" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Sudah Punya Akun?
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="text-center mt-4 mt-lg-0">
                    <div class="bg-white p-4 rounded-4 shadow-lg d-inline-block">
                        <i class="fas fa-graduation-cap" style="font-size: 4rem; color: #667eea;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-graduation-cap me-2"></i>SIMPRAK
                </h5>
                <p class="text-white small">
                    Sistem Informasi Pengumpulan Tugas Praktikum yang memudahkan mahasiswa dalam mengelola tugas akademik.
                </p>
            </div>
            
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Menu</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none small">Beranda</a></li>
                    <li><a href="#fitur" class="text-white text-decoration-none small">Fitur</a></li>
                    <li><a href="#cara-kerja" class="text-white text-decoration-none small">Cara Kerja</a></li>
                    <li><a href="login.php" class="text-white text-decoration-none small">Login</a></li>
                </ul>
            </div>
            
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Kontak</h6>
                <p class="text-white small mb-2">
                    <i class="fas fa-envelope me-2"></i>
                    info@simprak.ac.id
                </p>
                <p class="text-white small mb-3">
                    <i class="fas fa-phone me-2"></i>
                    +62 274 123 4567
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        
        <hr class="my-4">
        
        <div class="text-center">
            <p class="text-white small mb-0">&copy; <?= date("Y") ?> SIMPRAK. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Navbar background on scroll
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('shadow');
    } else {
        navbar.classList.remove('shadow');
    }
});
</script>

</body>
</html>