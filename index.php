<?php
session_start();
include 'config.php';

$artworkDir = 'uploads/artwork';
$audioDir   = 'uploads/audio';
if (!is_dir($artworkDir)) mkdir($artworkDir, 0777, true);
if (!is_dir($audioDir)) mkdir($audioDir, 0777, true);

// AUTO-LOGIN VIA COOKIE
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'], $_COOKIE['user_token'])) {
    $user_id = $_COOKIE['user_id'];
    $token   = $_COOKIE['user_token'];

    $stmt = $conn->prepare("SELECT id, name, role FROM users WHERE id=? AND token=? LIMIT 1");
    $stmt->bind_param("is", $user_id, $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role']      = $user['role'];
    }
}

// Search
$search = $_GET['search'] ?? '';
if (!empty($search)) {
    $searchParam = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM music WHERE title LIKE ? OR artist_name LIKE ? ORDER BY uploaded_at DESC");
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM music ORDER BY uploaded_at DESC");
}

// Trending (top 5 by likes+downloads)
$trending = $conn->query("SELECT * FROM music ORDER BY (likes + downloads) DESC LIMIT 5");

// Featured Artists (unique artist names)
$artists = $conn->query("SELECT DISTINCT artist_name, artwork FROM music ORDER BY RAND() LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TRICK-TUNES</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-950 text-slate-100 font-sans">

<!-- Navbar -->
<header class="sticky top-0 z-50 bg-slate-900/90 backdrop-blur-md shadow-lg animate__animated animate__fadeInDown">
  <div class="container mx-auto flex items-center justify-between px-6 py-4">
    <a href="index.php" class="text-2xl font-extrabold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">TRICK-TUNES</a>
    <nav id="navbar" class="hidden md:flex space-x-6 text-sm font-medium">
      <a href="#latest" class="hover:text-cyan-400 transition">Home</a>
      <a href="#about" class="hover:text-cyan-400 transition">About</a>
      <a href="#trending" class="hover:text-cyan-400 transition">Trending</a>
      <a href="#artists" class="hover:text-cyan-400 transition">Artists</a>
      <a href="contact.php" class="hover:text-cyan-400 transition">Contact</a>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php" class="hover:text-cyan-400 transition">Dashboard</a>
        <a href="logout.php" class="hover:text-red-500 transition">Logout</a>
      <?php else: ?>
        <a href="register.php" class="hover:text-cyan-400 transition">Register</a>
        <a href="login.php" class="hover:text-cyan-400 transition">Login</a>
      <?php endif; ?>
    </nav>
    <button id="menuBtn" class="md:hidden text-2xl"><i class="fa fa-bars"></i></button>
  </div>
</header>

<!-- Search -->
<div class="sticky top-16 z-40 bg-slate-800/80 backdrop-blur-lg py-3 shadow-md">
  <div class="container mx-auto px-6">
    <form action="index.php" method="GET" class="flex gap-2">
      <input type="text" name="search" placeholder="Search songs, artists..." 
             value="<?php echo htmlspecialchars($search); ?>"
             class="flex-1 px-4 py-2 rounded-lg bg-slate-900 text-slate-100 focus:outline-none focus:ring-2 focus:ring-cyan-500">
      <button type="submit" class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-400 hover:to-purple-400 rounded-lg text-white font-semibold">Search</button>
    </form>
  </div>
</div>

<!-- Hero -->
<section class="relative bg-gradient-to-r from-cyan-700 via-purple-700 to-slate-900">
  <div class="container mx-auto grid md:grid-cols-2 gap-10 px-6 py-20 items-center">
    <div class="animate__animated animate__fadeInLeft">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">Without Music, Life Would Be a Mistake</h1>
      <p class="mt-4 text-lg text-slate-300">Stream, share, and download your favorite tracks on TRICK-TUNES.</p>
      <a href="login.php" class="mt-6 inline-block bg-gradient-to-r from-cyan-500 to-purple-500 hover:from-cyan-400 hover:to-purple-400 px-6 py-3 rounded-lg shadow-lg font-semibold">Get Started</a>
    </div>
    <div class="flex justify-center animate__animated animate__fadeInRight">
      <img src="images/5.png" alt="Music Illustration" class="w-80 drop-shadow-xl hover:scale-105 transition duration-500">
    </div>
  </div>
</section>

<!-- About -->
<section id="about" class="container mx-auto px-6 py-20 text-center">
  <h2 class="text-3xl font-bold mb-6">About TRICK-TUNES</h2>
  <p class="max-w-2xl mx-auto text-slate-300 leading-relaxed">
    TRICK-TUNES is a Malawian music platform designed to connect artists and listeners. 
    We give artists the stage to showcase their talent while fans enjoy unlimited streaming and downloads.
  </p>
</section>

<!-- Trending -->
<section id="trending" class="container mx-auto px-6 py-16">
  <h2 class="text-3xl font-bold text-center mb-10">🔥 Trending Now</h2>
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php while($row = $trending->fetch_assoc()):
        $artwork = $row['artwork'] ?: 'default.png';
        $artworkPath = file_exists("$artworkDir/$artwork") ? "$artworkDir/$artwork" : "$artworkDir/default.png";
        $artist  = $row['artist_name'] ?: 'Unknown Artist';
        $title   = $row['title'] ?: 'Untitled';
        $likes   = $row['likes'] ?: 0;
        $downloads = $row['downloads'] ?: 0;
    ?>
    <div class="bg-gradient-to-r from-purple-800/40 to-cyan-800/40 rounded-xl shadow-lg overflow-hidden p-5 hover:scale-105 transition">
      <img src="<?php echo $artworkPath; ?>" class="w-full h-48 object-cover rounded-lg">
      <h3 class="mt-4 font-bold"><?php echo $artist; ?> - <?php echo $title; ?></h3>
      <p class="text-sm text-slate-400 mt-1">Likes: <?php echo $likes; ?> | Downloads: <?php echo $downloads; ?></p>
    </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Featured Artists -->
<section id="artists" class="bg-slate-900/80 py-16">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold text-center mb-10">🎤 Featured Artists</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
      <?php while($row = $artists->fetch_assoc()):
          $pic = $row['artwork'] ?: 'default.png';
          $artworkPath = file_exists("$artworkDir/$pic") ? "$artworkDir/$pic" : "$artworkDir/default.png";
      ?>
      <div class="text-center">
        <img src="<?php echo $artworkPath; ?>" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-cyan-500 shadow-md">
        <p class="mt-2 text-sm font-medium"><?php echo htmlspecialchars($row['artist_name']); ?></p>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Genres -->
<section class="container mx-auto px-6 py-16 text-center">
  <h2 class="text-3xl font-bold mb-10">🎶 Browse by Genre</h2>
  <div class="flex flex-wrap justify-center gap-4">
    <span class="px-5 py-2 bg-slate-800 rounded-full hover:bg-cyan-500 transition">Afrobeat</span>
    <span class="px-5 py-2 bg-slate-800 rounded-full hover:bg-cyan-500 transition">Hip-Hop</span>
    <span class="px-5 py-2 bg-slate-800 rounded-full hover:bg-cyan-500 transition">Gospel</span>
    <span class="px-5 py-2 bg-slate-800 rounded-full hover:bg-cyan-500 transition">Jazz</span>
    <span class="px-5 py-2 bg-slate-800 rounded-full hover:bg-cyan-500 transition">Reggae</span>
    <span class="px-5 py-2 bg-slate-800 rounded-full hover:bg-cyan-500 transition">Traditional</span>
  </div>
</section>

<!-- Latest Uploads -->
<main id="latest" class="container mx-auto px-6 py-16">
  <h2 class="text-3xl font-bold text-center mb-10">📀 Latest Uploads</h2>
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php if($result && $result->num_rows > 0): while($row = $result->fetch_assoc()):
        $artworkFile = $row['artwork'] ?: 'default.png';
        $artworkPath = file_exists("$artworkDir/$artworkFile") ? "$artworkDir/$artworkFile" : "$artworkDir/default.png";
        $audioFile = $row['audio'] ?: '';
        $audioPath = ($audioFile && file_exists("$audioDir/$audioFile")) ? "$audioDir/$audioFile" : '';
        $artist = $row['artist_name'] ?: 'Unknown Artist';
        $title  = $row['title'] ?: 'Untitled';
        $likes  = $row['likes'] ?: 0;
    ?>
    <div class="bg-slate-900/70 rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition">
      <img src="<?php echo $artworkPath; ?>" class="w-full h-48 object-cover">
      <div class="p-5 text-center">
        <h3 class="font-bold"><?php echo $artist; ?> - <?php echo $title; ?></h3>
        <?php if($audioPath): ?>
        <audio controls class="w-full mt-3">
          <source src="<?php echo $audioPath; ?>" type="audio/mpeg">
        </audio>
        <?php endif; ?>
        <div class="flex justify-between text-sm mt-3">
          <span><i class="fa fa-heart text-rose-400"></i> <?php echo $likes; ?> Likes</span>
          <a href="<?php echo $audioPath; ?>" download class="hover:text-cyan-400"><i class="fa fa-download"></i> Download</a>
        </div>
      </div>
    </div>
    <?php endwhile; else: ?>
    <p class="text-center text-slate-400 col-span-3">No music tracks found.</p>
    <?php endif; ?>
  </div>
</main>

<!-- Call to Action -->
<section class="bg-gradient-to-r from-cyan-600 to-purple-600 py-20 text-center">
  <h2 class="text-4xl font-bold mb-4">Are You an Artist?</h2>
  <p class="mb-6">Upload your tracks today and reach thousands of listeners on TRICK-TUNES.</p>
  <a href="register.php" class="bg-white text-slate-900 px-6 py-3 rounded-lg font-semibold hover:bg-slate-200">Join Now</a>
</section>

<!-- Footer -->
<footer class="bg-slate-900/90 text-center py-10 mt-12">
  <p class="text-sm text-slate-400">© 2025 TRICK-TUNES. Designed with ❤️ by Patrick Matemba</p>
</footer>

<script>
document.getElementById('menuBtn').addEventListener('click', () => {
  document.getElementById('navbar').classList.toggle('hidden');
});
</script>
</body>
</html>
