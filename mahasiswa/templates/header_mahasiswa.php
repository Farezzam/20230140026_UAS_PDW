<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
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
    <title><?php echo isset($pageTitle) ? $pageTitle : 'SIMPRAK'; ?> - Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .nav-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .nav-item {
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #ffffff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-item:hover::after {
            width: 100%;
        }
        
        .nav-item.active::after {
            width: 100%;
        }
        
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

<!-- Navigation -->
<nav class="nav-gradient shadow-2xl relative z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18">
            <!-- Logo -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="dashboard.php" class="flex items-center space-x-3 group">
                        <div class="bg-white p-2 rounded-xl shadow-lg group-hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-graduation-cap text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent"></i>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-xl">SIMPRAK</h1>
                            <p class="text-blue-100 text-xs">Sistem Praktikum</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-2">
                    <a href="dashboard.php" class="nav-item <?php echo ($activePage == 'dashboard') ? 'active bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10'; ?> px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="praktikum_saya.php" class="nav-item <?php echo ($activePage == 'praktikum_saya') ? 'active bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10'; ?> px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        <i class="fas fa-book mr-2"></i>Praktikum Saya
                    </a>
                    <a href="praktikum_katalog.php" class="nav-item <?php echo ($activePage == 'katalog') ? 'active bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10'; ?> px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                        <i class="fas fa-th-large mr-2"></i>Katalog
                    </a>
                </div>
            </div>

            <!-- User Menu -->
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6 space-x-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 rounded-full p-2">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <span class="text-white font-medium">Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                    </div>
                    <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="open = !open" class="bg-white bg-opacity-20 p-2 rounded-lg text-white hover:bg-opacity-30 transition-all duration-300">
                    <i class="fas fa-bars" x-show="!open"></i>
                    <i class="fas fa-times" x-show="open"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white bg-opacity-10 backdrop-blur-md">
            <a href="dashboard.php" class="<?php echo ($activePage == 'dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10'; ?> block px-3 py-2 rounded-md text-base font-medium">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </a>
            <a href="praktikum_saya.php" class="<?php echo ($activePage == 'praktikum_saya') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10'; ?> block px-3 py-2 rounded-md text-base font-medium">
                <i class="fas fa-book mr-2"></i>Praktikum Saya
            </a>
            <a href="praktikum_katalog.php" class="<?php echo ($activePage == 'katalog') ? 'bg-white bg-opacity-20 text-white' : 'text-blue-100 hover:text-white hover:bg-white hover:bg-opacity-10'; ?> block px-3 py-2 rounded-md text-base font-medium">
                <i class="fas fa-th-large mr-2"></i>Katalog
            </a>
            <div class="border-t border-white border-opacity-20 pt-3 mt-3">
                <div class="flex items-center px-3 py-2">
                    <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <span class="text-white font-medium"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                </div>
                <a href="../logout.php" class="block px-3 py-2 text-base font-medium text-white bg-red-500 hover:bg-red-600 rounded-md mt-2">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="fade-in">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">