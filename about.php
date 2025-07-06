<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8">
  <title>About | Personal Web</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { darkMode: 'class' }</script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-teal-100 text-gray-800 dark:bg-gray-900 dark:text-white font-sans">
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
    About<br>Me
  </h1>
  <p class="text-black text-xl font-bold [font-family:'Quicksand',sans-serif] mt-2 drop-shadow-[0_0_10px_rgba(191,64,255,0.8)] dark:text-white dark:drop-shadow-[0_0_16px_rgba(255,255,255,0.95)]">
    Devi <span class="text-pink-400">Lestari</span>
  </p>
</header>

<!-- Navigation -->
<nav class="bg-gradient-to-r from-purple-400 via-pink-200 to-purple-400 text-black font-bold py-3 
            dark:from-gray-900 dark:via-indigo-900 dark:to-purple-900 dark:text-white relative overflow-hidden">
  <ul class="relative z-10 flex justify-center space-x-10 text-lg">
    <li><a href="index.php" class="hover:underline">Artikel</a></li>
    <li><a href="gallery.php" class="hover:underline">Gallery</a></li>
    <li><a href="about.php" class="hover:underline">About</a></li>
    <li><a href="admin/login.php" class="hover:underline">Login</a></li>
  </ul>
</nav>

<main class="max-w-5xl mx-auto mt-10 px-6 py-8 bg-white dark:bg-gray-800 rounded shadow-lg flex flex-col md:flex-row items-center md:items-start gap-8 relative overflow-hidden transition-all duration-300">
  <!-- FOTO PROFIL -->
  <div class="flex-shrink-0 relative z-10">
    <img src="images/WhatsApp Image 2025-07-05 at 23.59.20_6c335cf8.jpg" alt="Foto Devi" 
         class="w-64 h-64 object-cover rounded-full border-[6px] border-pink-400 shadow-xl ring-4 ring-purple-300 dark:ring-yellow-200 hover:scale-105 transition duration-300">
  </div>

  <!-- DESKRIPSI dari database -->
  <div class="flex-1 bg-purple-100 dark:bg-gradient-to-r dark:from-indigo-900 dark:to-purple-900 p-6 rounded shadow text-gray-800 dark:text-violet-100 relative z-10">
    <h2 class="text-2xl font-bold mb-4">Tentang Saya</h2>
    <div class="space-y-4 text-gray-700 dark:text-gray-300 leading-relaxed">
      <?php
      $sql = "SELECT * FROM tbl_about ORDER BY id_about DESC";
      $query = mysqli_query($db, $sql);
      while ($data = mysqli_fetch_array($query)) {
        echo "<p>" . nl2br(htmlspecialchars($data['about'])) . "</p>";
      }
      ?>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="bg-gradient-to-r from-purple-400 via-pink-200 to-purple-400 text-black font-bold text-center py-4 mt-10 
                dark:from-gray-900 dark:via-indigo-900 dark:to-purple-900 dark:text-white relative overflow-hidden">
  <div class="relative z-10">
    &copy; <?php echo date('Y'); ?> | Created by Devi Lestari
  </div>
</footer>

<!-- Script Dark Mode dan Animasi bunga dam bintangg -->
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