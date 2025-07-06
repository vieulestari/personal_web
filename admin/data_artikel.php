<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8">
  <title>Kelola Artikel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { darkMode: 'class' }</script>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700;800&family=Henny+Penny&display=swap" rel="stylesheet">
  <style>
    .henny-penny { font-family: 'Henny Penny', cursive; }
    .quicksand { font-family: 'Quicksand', sans-serif; }
  </style>
</head>

<body class="bg-gradient-to-br from-purple-100 via-pink-100 to-blue-200 
             text-gray-800 dark:bg-gradient-to-br dark:from-blue-900 dark:via-purple-900 dark:to-blue-900 
             dark:text-violet-100 quicksand transition-all duration-300 min-h-screen relative">
  <!-- Canvas untuk Light Mode: Daun & Bunga -->
<div class="absolute inset-0 pointer-events-none z-0 block dark:hidden">
  <canvas class="leaf-canvas w-full h-full"></canvas>
</div>
  <!-- star background -->
<div class="absolute inset-0 pointer-events-none z-0 star-canvas-container hidden dark:block">
  <canvas class="star-canvas w-full h-full"></canvas>
</div>

<!-- Tombol Dark Mode -->
<button id="toggleDark" class="fixed top-4 right-4 z-50 bg-white dark:bg-gray-800 text-black dark:text-white px-4 py-2 rounded shadow hover:scale-105 transition">
  🌙
</button>

<!-- Header -->
<header class="bg-gradient-to-r from-purple-300 via-yellow-100 via-pink-200 to-blue-200 
               dark:from-indigo-900 dark:via-purple-800 dark:to-indigo-900 text-center py-8 shadow dark:text-white">
  <h1 class="text-3xl font-bold [font-family:'Henny_Penny',cursive] bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 dark:text-yellow-200 
             bg-clip-text text-transparent drop-shadow-[0_0_12px_rgba(255,255,255,0.8)]">
    Halaman Admin
  </h1>
</header>

<!-- Layout -->
<div class="flex max-w-7xl mx-auto mt-8 px-4 gap-6">
  <!-- Sidebar -->
  <aside class="w-1/4 bg-white dark:bg-gray-800 rounded shadow p-4 text-sm dark:text-gray-200">
    <h2 class="text-xl font-semibold text-purple-700 dark:text-pink-300 mb-4 text-center">MENU</h2>
    <ul class="space-y-2">
      <li><a href="beranda_admin.php" class="block hover:text-purple-600 dark:hover:text-pink-400">Beranda</a></li>
      <li><a href="data_artikel.php" class="block font-semibold text-purple-800 dark:text-white">Kelola Artikel</a></li>
      <li><a href="kelola_komentar.php" class="block font-semibold text-purple-800 dark:text-white">Kelola Komentar</a></li>
      <li><a href="data_gallery.php" class="block hover:text-purple-600 dark:hover:text-pink-400">Kelola Gallery</a></li>
      <li><a href="about.php" class="block hover:text-purple-600 dark:hover:text-pink-400">About</a></li>
      <li>
        <a href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar?');"
           class="block text-red-600 hover:underline font-medium dark:text-red-400">Logout</a>
      </li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="w-3/4 bg-white dark:bg-gray-800 rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">Daftar Artikel</h2>
      <a href="add_artikel.php"
         class="bg-gradient-to-r from-pink-400 to-purple-500 text-white px-4 py-2 rounded shadow hover:brightness-110 transition">
        + Tambah Artikel
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full table-auto border border-gray-300 text-sm dark:border-gray-600">
        <thead class="bg-purple-500 text-white">
          <tr>
            <th class="p-3 border dark:border-gray-600">No</th>
            <th class="p-3 border dark:border-gray-600">Nama Artikel</th>
            <th class="p-3 border dark:border-gray-600">Isi Artikel</th>
            <th class="p-3 border dark:border-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="dark:text-gray-100">
          <?php
          $sql = "SELECT * FROM tbl_artikel ORDER BY id_artikel DESC";
          $query = mysqli_query($db, $sql);
          $no = 1;
          while ($data = mysqli_fetch_array($query)) {
            echo "<tr class='even:bg-gray-50 dark:even:bg-gray-700'>";
            echo "<td class='border p-2 text-center dark:border-gray-600'>" . $no++ . "</td>";
            echo "<td class='border p-2 dark:border-gray-600'>" . htmlspecialchars($data['nama_artikel']) . "</td>";
            echo "<td class='border p-2 dark:border-gray-600'>" . htmlspecialchars($data['isi_artikel']) . "</td>";
            echo "<td class='border p-2 text-center space-x-2 dark:border-gray-600'>
                    <a href='edit_artikel.php?id_artikel={$data['id_artikel']}' class='text-blue-600 dark:text-blue-300 hover:underline'>Edit</a>
                    <a href='delete_artikel.php?id_artikel={$data['id_artikel']}' onclick='return confirm(\"Yakin ingin menghapus?\")'
                       class='text-red-600 dark:text-red-400 hover:underline'>Hapus</a>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- Footer -->
<footer class="bg-gradient-to-r from-purple-300 via-yellow-100 via-pink-200 to-blue-200
               dark:from-indigo-900 dark:via-purple-800 dark:to-indigo-900
               text-center py-4 shadow dark:text-white 
               text-center py-4 mt-10 font-bold transition-all duration-300">
  &copy; <?php echo date('Y'); ?> | Created by Devi Lestari
</footer>

<!-- Script Dark Mode dan animasi bungan dan bintang-->
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

    if (mode === 'dark') {
      startStars();
    } else {
      startLeaves();
    }
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
      color: Math.random() > 0.5 ? "#A3D977" : "#FFC0CB" // daun hijau atau bunga pink
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