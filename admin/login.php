<?php
session_start();
if (isset($_SESSION['username'])) {
  header('location:beranda_admin.php');
}
require_once("../koneksi.php");
?>
<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8">
  <title>Login Administrator</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    };
  </script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700;800&display=swap" rel="stylesheet">
  <style>
    .quicksand { font-family: 'Quicksand', sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-br from-purple-100 via-pink-100 to-blue-200 
             text-gray-800 dark:bg-gradient-to-br dark:from-indigo-900 dark:to-purple-900 dark:text-violet-100 
             quicksand transition-all duration-300 min-h-screen flex items-center justify-center relative">
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

  <!-- Form Login -->
  <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-8 w-full max-w-md border border-purple-200 dark:border-purple-600 z-10 relative">
    <h2 class="text-3xl font-bold text-center text-purple-700 dark:text-pink-300 mb-6 drop-shadow-sm">
      Login Admin
    </h2>

    <form action="cek_login.php" method="post" class="space-y-5">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Username</label>
        <input type="text" name="username" id="username" required
               class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-300 
                      dark:bg-gray-700 dark:text-white dark:border-gray-600">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Password</label>
        <input type="password" name="password" id="password" required
               class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-purple-300 
                      dark:bg-gray-700 dark:text-white dark:border-gray-600">
      </div>

      <div class="flex justify-between items-center">
        <input type="submit" name="login" value="Login"
               class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition cursor-pointer">
        <input type="reset" name="cancel" value="Batal"
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 
                      dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500 transition cursor-pointer">
      </div>
    </form>

    <div class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
      &copy; <?php echo date('Y'); ?> | Created by Devi Lestari
    </div>
  </div>

  <!-- Script Dark Mode -->
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
