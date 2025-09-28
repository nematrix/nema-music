<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - TRICK-TUNES</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-900 text-slate-100 font-sans">

  <!-- Navbar -->
  <header class="sticky top-0 z-50 bg-gradient-to-r from-indigo-600 to-purple-600 shadow-md animate__animated animate__fadeInDown">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">
      <a href="index.php" class="text-2xl font-bold tracking-wide hover:text-cyan-300 transition">TRICK-TUNES</a>
      <nav class="hidden md:flex space-x-6">
        <a href="index.php" class="hover:text-cyan-400 transition">Home</a>
        <a href="about.php" class="hover:text-cyan-400 transition">About</a>
        <a href="contact.php" class="hover:text-cyan-400 transition">Contact</a>
        <a href="#" onclick="openModal('registerModal')" class="hover:text-cyan-400 transition">Register</a>
        <a href="#" onclick="openModal('loginModal')" class="hover:text-cyan-400 transition">Login</a>
      </nav>
      <button id="menuBtn" class="md:hidden text-2xl"><i class="fa fa-bars"></i></button>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-indigo-700 via-purple-700 to-slate-900 py-20 text-center">
    <h1 class="text-4xl md:text-6xl font-extrabold mb-4">About TRICK-TUNES</h1>
    <p class="text-slate-300 text-lg max-w-2xl mx-auto">Learn more about TRICK-TUNES, our mission, and how we connect artists and music lovers across Malawi.</p>
  </section>

  <!-- Our Mission -->
  <section class="container mx-auto px-6 py-16 text-center">
    <h2 class="text-3xl font-bold mb-6">Our Mission</h2>
    <p class="text-slate-300 max-w-3xl mx-auto">
      TRICK-TUNES aims to empower Malawian artists by giving them a platform to showcase their talent and reach fans easily. 
      We want to create a seamless experience for music lovers to stream, share, and download their favorite tracks.
    </p>
  </section>

  <!-- Our Vision -->
  <section class="bg-slate-800 py-16 text-center">
    <h2 class="text-3xl font-bold mb-6">Our Vision</h2>
    <p class="text-slate-300 max-w-3xl mx-auto">
      We envision a thriving Malawian music industry where artists are recognized and fans enjoy unrestricted access to high-quality music.
    </p>
  </section>

  <!-- Our Team -->
  <section class="container mx-auto px-6 py-16 text-center">
    <h2 class="text-3xl font-bold mb-8">Meet The Team</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="p-6 bg-slate-800 rounded-xl shadow-lg hover:scale-105 transition">
        <img src="images/team1.jpg" alt="Team Member" class="w-24 h-24 mx-auto rounded-full mb-4">
        <h3 class="text-xl font-semibold">Patrick Matemba</h3>
        <p class="text-slate-400">Founder & Developer</p>
      </div>
      <div class="p-6 bg-slate-800 rounded-xl shadow-lg hover:scale-105 transition">
        <img src="images/team2.jpg" alt="Team Member" class="w-24 h-24 mx-auto rounded-full mb-4">
        <h3 class="text-xl font-semibold">Artist Manager</h3>
        <p class="text-slate-400">Talent & Content Manager</p>
      </div>
      <div class="p-6 bg-slate-800 rounded-xl shadow-lg hover:scale-105 transition">
        <img src="images/team3.jpg" alt="Team Member" class="w-24 h-24 mx-auto rounded-full mb-4">
        <h3 class="text-xl font-semibold">Marketing Lead</h3>
        <p class="text-slate-400">Promotion & Outreach</p>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="bg-gradient-to-r from-indigo-600 to-purple-600 py-16 text-center">
    <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
    <p class="text-slate-200 mb-6">Subscribe to get the latest music updates from TRICK-TUNES</p>
    <form class="max-w-lg mx-auto flex gap-2">
      <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-2 rounded-lg bg-slate-100 text-slate-900" required>
      <button class="px-6 py-2 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white">Subscribe</button>
    </form>
  </section>

  <!-- Footer -->
  <footer class="bg-slate-800 text-center py-10 mt-12 animate__animated animate__fadeInUp">
    <h2 class="text-xl font-semibold mb-4">Follow Us</h2>
    <div class="flex justify-center space-x-6 text-2xl">
      <a href="#" class="hover:text-blue-500 transition transform hover:scale-125"><i class="fab fa-facebook"></i></a>
      <a href="#" class="hover:text-cyan-400 transition transform hover:scale-125"><i class="fab fa-twitter"></i></a>
      <a href="#" class="hover:text-pink-500 transition transform hover:scale-125"><i class="fab fa-instagram"></i></a>
    </div>
    <p class="mt-6 text-sm text-slate-400">© 2025 TRICK-TUNES. Designed with ❤️ by Patrick Matemba</p>
  </footer>

  <!-- LOGIN & REGISTER MODALS -->
  <?php include 'modals.php'; ?>

  <script>
    function openModal(id){ document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id){ document.getElementById(id).classList.add('hidden'); }
    function switchToRegister(){ closeModal('loginModal'); openModal('registerModal'); }
    function switchToLogin(){ closeModal('registerModal'); openModal('loginModal'); }
  </script>

</body>
</html>
