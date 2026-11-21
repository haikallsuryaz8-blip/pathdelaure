<?php
// C:\laragon\www\kewirausahaan\admin\login.php
require_once __DIR__ . '/../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Silakan isi username dan password!';
    } elseif (!isset($pdo)) {
        $error = 'Koneksi database tidak tersedia.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];

            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Kasir — <?= BRAND_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-gray-900 border border-gray-800 rounded-2xl p-6 md:p-8 shadow-2xl">
        <div class="text-center mb-6">
            <span class="inline-block px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-xs font-semibold rounded-full mb-3 tracking-widest uppercase">Portal Stand Bazar</span>
            <h1 class="text-2xl font-bold tracking-tight"><?= BRAND_NAME ?></h1>
            <p class="text-xs text-gray-400 mt-1"><?= BRAND_TAGLINE ?></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 text-red-400 text-xs rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-medium text-gray-300 mb-1">Username Anggota</label>
                <input type="text" name="username" required autocomplete="username" placeholder="haikal / aji / alhikam / jasir / meisyiah / naura" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-300 mb-1">Password</label>
                <input type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full bg-gray-800/80 border border-gray-700 rounded-xl px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-gray-950 font-bold py-3 rounded-xl transition duration-200 text-sm shadow-lg shadow-amber-500/20">
                Masuk ke Panel Kasir
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-800/60 text-center">
            <a href="../index.php" class="text-xs text-gray-400 hover:text-amber-400 transition">&larr; Kembali ke Katalog Utama</a>
        </div>
    </div>
</body>
</html>
