<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Personal Web | Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    };
  </script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700;800&display=swap" rel="stylesheet">
  <style>
  html {
    scroll-behavior: smooth;
  }

  @keyframes fadeInUp {
    0% {
      opacity: 0;
      transform: translateY(20px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
  }
</style>
</head>

<body class="fade-in-up transition-all duration-500 bg-teal-100 text-gray-800 dark:bg-gray-900 dark:text-white font-sans">
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
dark:from-indigo-900 dark:via-purple-800 dark:to-gray-900 text-center py-8 dark:text-white">
  <h1 class="text-5xl font-bold [font-family:'Henny_Penny',cursive] bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 dark:text-yellow-200
bg-clip-text text-transparent leading-tight drop-shadow-[0_0_16px_rgba(255,255,255,0.95)]">
    Devi<br>Lestari
  </h1>
  <p class="text-black text-xl font-bold [font-family:'Quicksand',sans-serif] mt-2 drop-shadow-[0_0_10px_rgba(191,64,255,0.8)] dark:text-white dark:drop-shadow-[0_0_16px_rgba(255,255,255,0.95)]">
    Personal <span class="text-pink-400">Web</span>
  </p>
</header>

<!-- Navigation -->
<nav class="bg-gradient-to-r from-purple-400 via-pink-200 to-purple-400 text-black font-bold py-3 
            dark:from-gray-900 dark:via-indigo-900 dark:to-purple-900 dark:text-white relative overflow-hidden">
  <!-- Nav Content -->
  <ul class="relative z-10 flex justify-center space-x-10 font-medium text-lg">
    <li><a href="index.php" class="hover:underline">Artikel</a></li>
    <li><a href="gallery.php" class="hover:underline">Gallery</a></li>
    <li><a href="about.php" class="hover:underline">About</a></li>
    <li><a href="admin/login.php" class="hover:underline">Login</a></li>
  </ul>
</nav>

<!-- Main Content -->
<main class="fade-in-up max-w-6xl mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 
  bg-teal-100 dark:bg-gradient-to-br dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 transition duration-500">

  <!-- Artikel Utama -->
  <section class="md:col-span-2 bg-purple-300 p-6 rounded shadow 
    dark:bg-gradient-to-r dark:from-indigo-900 dark:to-purple-900 dark:text-violet-100 transition-all duration-500">

    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Artikel Terbaru</h2>

    <!-- Form Pencarian -->
    <form method="GET" action="index.php" class="mb-4 flex gap-2">
      <input type="text" name="keyword" placeholder="Cari artikel..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
        class="w-2/3 px-4 py-2 border border-purple-300 rounded dark:bg-gray-800 dark:text-white">
      <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Cari</button>
    </form>

    <?php
    $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($db, $_GET['keyword']) : '';
    $sql = "SELECT * FROM tbl_artikel";
    if ($keyword !== '') {
      echo "<p class='mb-4 text-sm text-gray-700 dark:text-gray-300'>
              Menampilkan hasil untuk: <strong>" . htmlspecialchars($keyword) . "</strong>
            </p>";
      $sql .= " WHERE nama_artikel LIKE '%$keyword%' OR isi_artikel LIKE '%$keyword%'";
    }
    $sql .= " ORDER BY id_artikel DESC";
    $query = mysqli_query($db, $sql);
    ?>

    <!-- List Artikel -->
    <div class="space-y-4">
      <?php while ($data = mysqli_fetch_array($query)) : ?>
        <div class="border-b pb-4 border-gray-400 dark:border-gray-600">
          <h3 class="text-lg font-semibold text-blue-700 dark:text-teal-200">
            <a href="artikel_detail.php?id=<?= $data['id_artikel'] ?>" class="hover:underline">
              <?= htmlspecialchars($data['nama_artikel']) ?>
            </a>
          </h3>
          <p class="text-gray-700 dark:text-gray-300">
            <?= htmlspecialchars($data['isi_artikel']) ?>
          </p>
          <a href="artikel_detail.php?id=<?= $data['id_artikel'] ?>" class="text-sm text-purple-600 hover:underline">
            Baca Selengkapnya
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- Sidebar -->
  <aside class="bg-pink-300 p-6 rounded shadow 
    dark:bg-gradient-to-br dark:from-purple-800 dark:via-indigo-700 dark:to-indigo-900 
    dark:text-violet-100 transition-all duration-500">
    <h2 class="text-lg font-bold mb-4 dark:text-pink-200">Daftar Artikel</h2>
    <ul class="space-y-2 list-disc list-inside text-gray-700 dark:text-blue-100">
      <?php
      $querySidebar = mysqli_query($db, "SELECT * FROM tbl_artikel ORDER BY id_artikel DESC LIMIT 10");
      while ($data = mysqli_fetch_array($querySidebar)) {
        echo "<li class='hover:text-pink-600 dark:hover:text-teal-200 transition'>" . htmlspecialchars($data['nama_artikel']) . "</li>";
      }
      ?>
    </ul>
  </aside>

</main>

<!-- Footer -->
<footer class="bg-gradient-to-r from-purple-400 via-pink-200 to-purple-400 text-black font-bold text-center py-4 mt-10 
                dark:from-gray-900 dark:via-indigo-900 dark:to-purple-900 dark:text-white relative overflow-hidden">
  <!-- Footer Content -->
  <div class="relative z-10">
    &copy; <?php echo date('Y'); ?> | Created by Devi Lestari
  </div>
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
