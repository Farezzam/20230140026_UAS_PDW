<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek jika pengguna belum login atau rolenya bukan asisten
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'asisten') {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../../config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Dashboard Asisten'; ?> - SIMPRAK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            transform: translateX(-50%);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        .nav-link:hover {
            color: #ffffff !important;
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            color: #ffffff !important;
        }
        
        .logo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 1.5rem;
        }
        
        .user-info {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 8px 16px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        
        .logout-btn:hover {
            background: linear-gradient(135deg, #ee5a24 0%, #ff6b6b 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(238,90,36,0.3);
        }
        
        .mobile-menu-btn {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 8px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .mobile-menu {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            margin-top: 8px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        
        .mobile-nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 4px 0;
        }
        
        .mobile-nav-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(8px);
        }
        
        .mobile-nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body>
<nav class="navbar text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="bg-white rounded-lg p-2 mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <a href="dashboard.php" class="text-xl font-bold text-white">
                    SIMPRAK Asisten
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="dashboard.php" class="nav-link px-3 py-2 text-white/80 hover:text-white transition-colors <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v10H8V5z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
                
                <a href="praktikum_manage.php" class="nav-link px-3 py-2 text-white/80 hover:text-white transition-colors <?php echo ($activePage == 'praktikum') ? 'active' : ''; ?>">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Kelola Praktikum</span>
                    </div>
                </a>
                
                <a href="laporan_masuk.php" class="nav-link px-3 py-2 text-white/80 hover:text-white transition-colors <?php echo ($activePage == 'laporan') ? 'active' : ''; ?>">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Laporan Masuk</span>
                    </div>
                </a>
            </div>

            <!-- User Info & Logout -->
            <div class="hidden md:flex items-center space-x-4">
                <div class="user-info">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-white font-medium">Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                    </div>
                </div>
                
                <a href="../logout.php" class="logout-btn px-4 py-2 text-white font-medium transition-all duration-300">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </div>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="mobile-menu-btn text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden">
        <div class="mobile-menu mx-4 p-4">
            <div class="space-y-2">
                <a href="dashboard.php" class="mobile-nav-link block px-4 py-3 text-gray-700 <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
                
                <a href="praktikum_manage.php" class="mobile-nav-link block px-4 py-3 text-gray-700 <?php echo ($activePage == 'praktikum') ? 'active' : ''; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Kelola Praktikum</span>
                    </div>
                </a>
                
                <a href="laporan_masuk.php" class="mobile-nav-link block px-4 py-3 text-gray-700 <?php echo ($activePage == 'laporan') ? 'active' : ''; ?>">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Laporan Masuk</span>
                    </div>
                </a>
            </div>
            
            <div class="border-t border-gray-200 mt-4 pt-4">
                <div class="flex items-center space-x-3 px-4 py-2 text-gray-700">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-medium"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                </div>
                
                <a href="../logout.php" class="mobile-nav-link block px-4 py-3 text-red-600 mt-2">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.toggle('hidden');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobileMenu');
    const menuButton = event.target.closest('.mobile-menu-btn');
    
    if (!menuButton && !mobileMenu.contains(event.target)) {
        mobileMenu.classList.add('hidden');
    }
});
</script>

<main class="py-8 px-4">
    <div class="max-w-7xl mx-auto">