<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - TRICK-TUNES</title>
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
    <h1 class="text-4xl md:text-6xl font-extrabold mb-4">Contact TRICK-TUNES</h1>
    <p class="text-slate-300 text-lg max-w-2xl mx-auto">We’d love to hear from you. Reach out for support, inquiries, or collaboration.</p>
  </section>

  <!-- Contact Form & Map -->
  <section class="container mx-auto px-6 py-16 grid md:grid-cols-2 gap-12">
    <!-- Contact Form -->
    <div class="bg-slate-800 p-8 rounded-xl shadow-lg animate__animated animate__fadeInLeft">
      <h2 class="text-3xl font-bold mb-6 text-center">Get in Touch</h2>
      <form action="send_message.php" method="POST" class="space-y-4">
        <input type="text" name="name" placeholder="Your Name" required class="w-full px-4 py-2 rounded-lg bg-slate-900/60 text-slate-100">
        <input type="email" name="email" placeholder="Your Email" required class="w-full px-4 py-2 rounded-lg bg-slate-900/60 text-slate-100">
        <input type="text" name="subject" placeholder="Subject" required class="w-full px-4 py-2 rounded-lg bg-slate-900/60 text-slate-100">
        <textarea name="message" placeholder="Your Message" rows="5" required class="w-full px-4 py-2 rounded-lg bg-slate-900/60 text-slate-100"></textarea>
        <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 py-2 rounded-lg text-white">Send Message</button>
      </form>
    </div>

    <!-- Google Map -->
    <div class="rounded-xl overflow-hidden shadow-lg animate__animated animate__fadeInRight">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.000000000!2d35.000000!3d-15.000000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sBlantyre%2C%20Malawi!5e0!3m2!1sen!2s!4v1695000000000" 
        width="100%" height="100%" class="min-h-[400px]" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
