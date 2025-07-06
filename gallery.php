<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8">
  <title>Gallery | Personal Web</title>
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
    Galeri<br>Foto
  </h1>
  <p class="text-black text-xl font-bold [font-family:'Quicksand',sans-serif] mt-2 drop-shadow-[0_0_10px_rgba(191,64,255,0.8)] dark:text-white dark:drop-shadow-[0_0_16px_rgba(255,255,255,0.95)]">
    Photo's of <span class="text-pink-400">ME</span>
  </p>
</header>

<!-- Navigation -->
<nav class="relative z-10 bg-gradient-to-r from-purple-400 via-pink-200 to-purple-400 text-black font-bold py-3 
            dark:from-gray-900 dark:via-indigo-900 dark:to-purple-900 dark:text-white overflow-hidden">
  <ul class="flex justify-center space-x-10 font-medium text-lg">
    <li><a href="index.php" class="hover:underline">Artikel</a></li>
    <li><a href="gallery.php" class="hover:underline">Gallery</a></li>
    <li><a href="about.php" class="hover:underline">About</a></li>
    <li><a href="admin/login.php" class="hover:underline">Login</a></li>
  </ul>
</nav>

<!-- Gallery -->
<main class="relative z-10 max-w-6xl mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6 
             bg-teal-100 dark:bg-gradient-to-br dark:from-indigo-900 dark:to-purple-900 dark:text-violet-100">
  <form method="GET" action="gallery.php" class="mb-6 flex gap-2">
  <input type="text" name="keyword" placeholder="Cari gallery..." 
         value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"
         class="w-2/3 px-4 py-2 border border-purple-300 rounded dark:bg-gray-800 dark:text-white">
  <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Cari</button>
</form>
  <?php
  $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($db, $_GET['keyword']) : '';
$sql = "SELECT * FROM tbl_gallery";
if ($keyword !== '') {
  echo "<p class='mb-4 text-sm text-gray-700 dark:text-gray-300'>Menampilkan hasil untuk: <strong>" . htmlspecialchars($keyword) . "</strong></p>";
  $sql .= " WHERE judul LIKE '%$keyword%'";
}
$sql .= " ORDER BY id_gallery DESC";
  $query = mysqli_query($db, $sql);
  while ($data = mysqli_fetch_array($query)) {
    echo "<div class='bg-white dark:bg-gray-800 rounded shadow overflow-hidden transform hover:scale-105 transition duration-300 relative z-10'>";
    echo "<img src='images/{$data['foto']}' onclick=\"showFullImage(this.src)\" class='w-full h-48 object-cover cursor-pointer hover:scale-105 transition rounded' alt='Gambar'>";
    echo "<div class='p-4'>";
    echo "<h3 class='text-lg font-semibold text-fuchsia-700 dark:text-blue-300'>" . htmlspecialchars($data['judul']) . "</h3>";
    echo "</div></div>";
  }
  ?>
</main>
<!-- Modal Full Image -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 hidden">
  <span onclick="closeModal()" class="absolute top-4 right-6 text-white text-3xl cursor-pointer">&times;</span>
  <img id="modalImage" src="" class="max-w-full max-h-[90vh] rounded shadow-xl">
</div>

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
<script>
  function showFullImage(src) {
    const modal = document.getElementById('modal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    modal.classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('modal').classList.add('hidden');
  }

  // Close modal if clicked outside image
  window.addEventListener('click', function(e) {
    const modal = document.getElementById('modal');
    const modalImage = document.getElementById('modalImage');
    if (e.target === modal) {
      closeModal();
    }
  });
</script>

</body>
</html>