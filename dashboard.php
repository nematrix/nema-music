<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard -TRICK-TUNES </title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-900 text-slate-100 font-sans flex">

<!-- Sidebar -->
<aside id="sidebar" class="bg-slate-800 w-64 min-h-screen transition-all duration-300 md:block hidden">
  <div class="p-6 flex flex-col h-full">
    <h2 class="text-2xl font-bold mb-6 text-center">🎵 TRICK-TUNES Admin</h2>
    <nav class="flex-1 space-y-2">
      <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-600 transition"><i class="fa fa-tachometer-alt"></i><span class="sidebar-text">Dashboard</span></a>
      <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-600 transition"><i class="fa fa-users"></i><span class="sidebar-text">Artists</span></a>
      <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-600 transition"><i class="fa fa-music"></i><span class="sidebar-text">Songs</span></a>
      <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-600 transition"><i class="fa fa-download"></i><span class="sidebar-text">Downloads</span></a>
      <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-600 transition"><i class="fa fa-heart"></i><span class="sidebar-text">Likes</span></a>
      <a href="index.html" class="flex items-center gap-3 p-3 rounded hover:bg-rose-600 transition mt-auto"><i class="fa fa-sign-out-alt"></i><span class="sidebar-text">Logout</span></a>
    </nav>
    <button id="collapseBtn" class="mt-6 bg-indigo-600 hover:bg-indigo-500 px-3 py-2 rounded transition"><i class="fa fa-angle-left"></i></button>
  </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="mobileMenu" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-40 hidden md:hidden">
  <div class="bg-slate-800 w-64 h-full p-6 animate__animated animate__fadeInLeft">
    <button id="closeMenu" class="text-white text-2xl mb-6"><i class="fa fa-times"></i></button>
    <nav class="flex flex-col space-y-4">
      <a href="#" class="hover:text-cyan-400 transition"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
      <a href="#" class="hover:text-cyan-400 transition"><i class="fa fa-users"></i> Artists</a>
      <a href="#" class="hover:text-cyan-400 transition"><i class="fa fa-music"></i> Songs</a>
      <a href="#" class="hover:text-cyan-400 transition"><i class="fa fa-download"></i> Downloads</a>
      <a href="#" class="hover:text-cyan-400 transition"><i class="fa fa-heart"></i> Likes</a>
      <a href="index.html" class="hover:text-rose-400 transition"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </nav>
  </div>
</div>

<!-- Main Content -->
<div class="flex-1 flex flex-col min-h-screen">

  <!-- Top Bar -->
  <header class="sticky top-0 z-50 bg-gradient-to-r from-indigo-600 to-purple-600 shadow-md flex justify-between items-center px-6 py-4">
    <button id="hamburgerBtn" class="text-2xl md:hidden"><i class="fa fa-bars"></i></button>
    <h1 class="text-xl font-bold">🎵 Admin Dashboard</h1>
    <a href="index.html" class="bg-rose-500 hover:bg-rose-400 px-4 py-2 rounded-lg shadow transition hidden md:block">
      <i class="fa fa-sign-out-alt"></i> Logout
    </a>
  </header>

  <main class="p-6 space-y-10 overflow-x-auto">

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
        <i class="fa fa-users text-3xl text-indigo-400"></i>
        <div>
          <h2 class="text-2xl font-bold" id="artistCount">120</h2>
          <p class="text-slate-400">Artists Registered</p>
        </div>
      </div>
      <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
        <i class="fa fa-music text-3xl text-cyan-400"></i>
        <div>
          <h2 class="text-2xl font-bold" id="songCount">450</h2>
          <p class="text-slate-400">Songs Available</p>
        </div>
      </div>
      <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
        <i class="fa fa-download text-3xl text-emerald-400"></i>
        <div>
          <h2 class="text-2xl font-bold" id="downloadCount">12,340</h2>
          <p class="text-slate-400">Total Downloads</p>
        </div>
      </div>
      <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
        <i class="fa fa-heart text-3xl text-rose-400"></i>
        <div>
          <h2 class="text-2xl font-bold" id="likeCount">8,765</h2>
          <p class="text-slate-400">Total Likes</p>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="bg-slate-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Downloads Over Time</h3>
        <canvas id="downloadsChart"></canvas>
      </div>
      <div class="bg-slate-800 rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-4">Likes Growth</h3>
        <canvas id="likesChart"></canvas>
      </div>
    </div>

    <!-- Music Table -->
    <div class="overflow-x-auto">
      <h3 class="text-lg font-semibold mb-4">Music Library</h3>
      <table class="w-full text-left border-collapse rounded-lg overflow-hidden">
        <thead class="bg-slate-800 text-slate-300 uppercase text-sm">
          <tr>
            <th class="p-3">Artwork</th>
            <th class="p-3">Title</th>
            <th class="p-3">Music</th>
            <th class="p-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd:bg-slate-800 even:bg-slate-700 hover:bg-slate-600 transition">
            <td class="p-3"><img src="images/artwork/1.jpg" class="w-16 h-16 object-cover rounded-lg"></td>
            <td class="p-3 font-semibold">Charizk</td>
            <td class="p-3"><audio controls class="w-48"><source src="music/6.Eli Njuchi – Zithe.mp3" type="audio/mpeg"></audio></td>
            <td class="p-3 flex justify-center space-x-3">
              <button class="bg-indigo-500 hover:bg-indigo-400 p-2 rounded-lg"><i class="fa fa-edit"></i></button>
              <button class="bg-rose-500 hover:bg-rose-400 p-2 rounded-lg"><i class="fa fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </main>

</div>

<script>
  // Hamburger toggle for mobile
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const closeMenu = document.getElementById('closeMenu');
  hamburgerBtn.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
  closeMenu.addEventListener('click', () => mobileMenu.classList.add('hidden'));

  // Sidebar collapse for desktop
  const collapseBtn = document.getElementById('collapseBtn');
  const sidebar = document.getElementById('sidebar');
  collapseBtn.addEventListener('click', () => {
    sidebar.classList.toggle('w-20');
    sidebar.querySelectorAll('.sidebar-text').forEach(el => el.classList.toggle('hidden'));
  });

  // Charts
  new Chart(document.getElementById('downloadsChart'), {
    type: 'line',
    data: { labels: ['Jan','Feb','Mar','Apr','May','Jun'], datasets: [{ label: 'Downloads', data: [500,1200,900,1500,2000,2500], borderColor:'#22d3ee', backgroundColor:'#22d3ee33', fill:true, tension:0.3 }] },
    options: { plugins: { legend: { labels: { color: 'white' } } }, scales: { x: { ticks: { color:'white' } }, y: { ticks: { color:'white' } } } }
  });
  new Chart(document.getElementById('likesChart'), {
    type: 'bar',
    data: { labels: ['Jan','Feb','Mar','Apr','May','Jun'], datasets: [{ label: 'Likes', data:[300,800,1200,1600,2100,2600], backgroundColor:'#f43f5e' }] },
    options: { plugins: { legend: { labels: { color: 'white' } } }, scales: { x: { ticks: { color:'white' } }, y: { ticks: { color:'white' } } } }
  });
</script>
</body>
</html>
