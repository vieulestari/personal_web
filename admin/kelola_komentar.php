<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:login.php');
  exit;
}

$query = mysqli_query($db, "SELECT * FROM tbl_komentar ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8">
  <title>Kelola Komentar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { darkMode: 'class' }</script>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&family=Henny+Penny&display=swap" rel="stylesheet">
  <style>
    .quicksand { font-family: 'Quicksand', sans-serif; }
    .henny-penny { font-family: 'Henny Penny', cursive; }
  </style>
</head>

<body class="bg-gradient-to-br from-purple-100 via-pink-100 to-blue-200 
             text-gray-800 dark:bg-gradient-to-br dark:from-blue-900 dark:via-purple-900 dark:to-blue-900 
             dark:text-violet-100 quicksand transition-all duration-300 min-h-screen relative">

<!-- Animasi Light Mode -->
<div class="absolute inset-0 pointer-events-none z-0 block dark:hidden">
  <canvas class="leaf-canvas w-full h-full"></canvas>
</div>
<!-- Animasi Dark Mode -->
<div class="absolute inset-0 pointer-events-none z-0 star-canvas-container hidden dark:block">
  <canvas class="star-canvas w-full h-full"></canvas>
</div>

<!-- Tombol Dark Mode -->
<button id="toggleDark" class="fixed top-4 right-4 z-50 bg-white dark:bg-gray-800 text-black dark:text-white px-4 py-2 rounded shadow hover:scale-105 transition">
  🌙
</button>

<!-- Header -->
<header class="bg-gradient-to-r from-purple-300 via-yellow-100 via-pink-200 to-blue-200
               dark:from-indigo-900 dark:via-purple-800 dark:to-indigo-900
               text-center py-8 shadow dark:text-white">
  <h1 class="text-3xl font-bold [font-family:'Henny_Penny',cursive] bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 dark:text-yellow-200 
             bg-clip-text text-transparent drop-shadow-[0_0_12px_rgba(255,255,255,0.8)]">
    Kelola Komentar Pengunjung
  </h1>
</header>

<!-- Layout -->
<div class="flex max-w-7xl mx-auto mt-8 px-4 gap-6">
  <!-- Sidebar -->
  <aside class="w-1/4 bg-white dark:bg-gray-800 rounded shadow p-4 text-sm dark:text-gray-200">
    <h2 class="text-xl font-semibold text-purple-700 dark:text-pink-300 mb-4 text-center">MENU</h2>
    <ul class="space-y-2">
      <li><a href="beranda_admin.php" class="block hover:text-purple-600 dark:hover:text-pink-400">Beranda</a></li>
      <li><a href="data_artikel.php" class="block hover:text-purple-600 dark:hover:text-pink-400">Kelola Artikel</a></li>
      <li><a href="kelola_komentar.php" class="block font-semibold text-purple-800 dark:text-white">Kelola Komentar</a></li>
      <li><a href="data_gallery.php" class="block hover:text-purple-600 dark:hover:text-pink-400">Kelola Gallery</a></li>
      <li><a href="about.php" class="block hover:text-purple-600 dark:hover:text-pink-400">About</a></li>
      <li><a href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');"
             class="block text-red-600 hover:underline font-medium dark:text-red-400">Logout</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="w-3/4 bg-white dark:bg-gray-800 rounded shadow p-6 overflow-x-auto">
    <h2 class="text-xl font-bold mb-4 text-purple-700 dark:text-pink-300">Moderasi Komentar</h2>
    <table class="min-w-full text-sm border border-gray-300 dark:border-gray-600 rounded">
      <thead class="bg-purple-200 dark:bg-purple-800 text-gray-800 dark:text-white">
        <tr>
          <th class="p-3 text-left">Nama</th>
          <th class="p-3 text-left">Komentar</th>
          <th class="p-3 text-left">Tanggal</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-purple-50 dark:hover:bg-gray-700 transition">
          <td class="p-3 font-medium"><?= htmlspecialchars($row['nama_pengunjung']) ?></td>
          <td class="p-3 whitespace-pre-line"><?= nl2br(htmlspecialchars($row['isi_komentar'])) ?></td>
          <td class="p-3"><?= $row['tanggal'] ?></td>
          <td class="p-3 font-semibold">
            <?php if ($row['status'] === 'pending') : ?>
              <span class="text-yellow-600">Pending</span>
            <?php elseif ($row['status'] === 'diterima') : ?>
              <span class="text-green-600">Diterima</span>
            <?php else : ?>
              <span class="text-red-600">Ditolak</span>
            <?php endif; ?>
          </td>
          <td class="p-3 space-x-2">
            <?php if ($row['status'] === 'pending') : ?>
              <a href="proses_moderasi.php?id=<?= $row['id_komentar'] ?>&aksi=terima" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Terima</a>
              <a href="proses_moderasi.php?id=<?= $row['id_komentar'] ?>&aksi=tolak" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Tolak</a>
            <?php endif; ?>
            <a href="proses_moderasi.php?id=<?= $row['id_komentar'] ?>&aksi=hapus" onclick="return confirm('Yakin hapus komentar?')" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded">Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</div>

<!-- Footer -->
<footer class="bg-gradient-to-r from-purple-300 via-yellow-100 via-pink-200 to-blue-200
               dark:from-indigo-900 dark:via-purple-800 dark:to-indigo-900
               text-center py-4 shadow dark:text-white 
               text-center py-4 mt-10 font-bold transition-all duration-300">
  &copy; <?php echo date('Y'); ?> | Created by Devi Lestari
</footer>

<!-- Script Dark Mode + Animasi -->
<script>
  const toggle = document.getElementById('toggleDark');
  const html = document.documentElement;

  if (localStorage.getItem('mode') === 'dark') {
    html.classList.add('dark');
    startStars();
  } else {
    startLeaves();
  }

  toggle.addEventListener('click', () => {
    html.classList.toggle('dark');
    const mode = html.classList.contains('dark') ? 'dark' : 'light';
    localStorage.setItem('mode', mode);
    mode === 'dark' ? startStars() : startLeaves();
  });

  function startStars() {
    const canvas = document.querySelector(".star-canvas");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    function resize() {
      canvas.width = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
    }
    window.addEventListener("resize", resize);
    resize();
    const stars = Array.from({ length: 100 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      r: Math.random() * 1.5 + 0.5,
      d: Math.random() * 0.5 + 0.1
    }));
    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = "white";
      stars.forEach(s => {
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
        ctx.fill();
      });
    }
    function update() {
      stars.forEach(s => {
        s.y += s.d;
        if (s.y > canvas.height) {
          s.y = 0;
          s.x = Math.random() * canvas.width;
        }
      });
    }
    function animate() {
      draw();
      update();
      requestAnimationFrame(animate);
    }
    animate();
  }

  function startLeaves() {
    const canvas = document.querySelector(".leaf-canvas");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    function resize() {
      canvas.width = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
    }
    window.addEventListener("resize", resize);
    resize();
    const leaves = Array.from({ length: 30 }, () => ({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 30 + 20,
      speed: Math.random() * 1 + 0.5,
      rotation: Math.random() * 360,
      rotateSpeed: Math.random() * 2 - 1,
      color: Math.random() > 0.5 ? "#A3D977" : "#FFC0CB"
    }));
    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      leaves.forEach(l => {
        ctx.save();
        ctx.translate(l.x, l.y);
        ctx.rotate((l.rotation * Math.PI) / 180);
        ctx.fillStyle = l.color;
        ctx.beginPath();
        ctx.ellipse(0, 0, l.size / 2, l.size / 4, 0, 0, 2 * Math.PI);
        ctx.fill();
        ctx.restore();
      });
    }
    function update() {
      leaves.forEach(l => {
        l.y += l.speed;
        l.rotation += l.rotateSpeed;
        if (l.y > canvas.height) {
          l.y = 0;
          l.x = Math.random() * canvas.width;
        }
      });
    }
    function animate() {
      draw();
      update();
      requestAnimationFrame(animate);
    }
    animate();
  }
</script>

</body>
</html>
