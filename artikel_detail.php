<?php
include "koneksi.php";

$id = intval($_GET['id']);
$query = mysqli_query($db, "SELECT * FROM tbl_artikel WHERE id_artikel = $id");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($data['nama_artikel']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    };
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet" />
</head>

<body class="bg-teal-100 text-gray-800 dark:bg-gray-900 dark:text-white font-sans">

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

<!-- Artikel Detail -->
<main class="relative z-10 max-w-3xl mx-auto mt-10 bg-white dark:bg-gradient-to-br dark:from-indigo-900 dark:to-purple-900 rounded shadow p-6 space-y-6">
  <h1 class="text-3xl font-bold text-gray-800 dark:text-yellow-100"><?= htmlspecialchars($data['nama_artikel']) ?></h1>
  <p class="text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($data['isi_artikel']) ?></p>

  <!-- Form Komentar -->
  <section>
    <h3 class="mt-10 font-bold text-lg text-purple-700 dark:text-pink-300">Tinggalkan Komentar</h3>
    <form action="admin/proses_komentar.php" method="POST" class="mt-4 space-y-3">
      <input type="hidden" name="id_artikel" value="<?= $data['id_artikel'] ?>">
      <input
        type="text"
        name="nama"
        placeholder="Nama Anda"
        required
        class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-600 dark:text-white"
      />
      <textarea
        name="komentar"
        placeholder="Komentar..."
        required
        rows="4"
        class="w-full p-2 rounded border dark:bg-gray-800 dark:border-gray-600 dark:text-white"
      ></textarea>
      <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
        Kirim
      </button>
    </form>
  </section>

  <!-- Komentar Pengunjung -->
  <section>
    <h3 class="mt-10 font-bold text-lg text-purple-700 dark:text-yellow-300">Komentar Pengunjung</h3>
    <div class="space-y-4 mt-4">
      <?php
      $id_artikel = $_GET['id'];
      $komentar_query = mysqli_query($db, "SELECT * FROM tbl_komentar WHERE id_artikel = '$id_artikel' AND status = 'diterima' ORDER BY tanggal DESC");

      if (mysqli_num_rows($komentar_query) > 0) {
        while ($komen = mysqli_fetch_assoc($komentar_query)) {
          echo "<div class='mb-4 p-4 border border-gray-300 dark:border-gray-600 rounded'>";
          echo "<p class='font-semibold text-blue-800 dark:text-blue-300'>" . htmlspecialchars($komen['nama_pengunjung']) . "</p>";
          echo "<p class='text-sm text-gray-600 dark:text-gray-400'>" . date('d M Y, H:i', strtotime($komen['tanggal'])) . "</p>";
          echo "<p class='mt-2 text-gray-800 dark:text-gray-200'>" . nl2br(htmlspecialchars($komen['isi_komentar'])) . "</p>";
          echo "</div>";
        }
      } else {
        echo "<p class='text-gray-500 dark:text-gray-400'>Belum ada komentar.</p>";
      }
      ?>
    </div>
  </section>
</main>

<!-- Script Dark Mode dan animasi -->
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
