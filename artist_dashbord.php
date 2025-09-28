<?php
session_start();
include 'config.php'; // mysqli connection

// Dummy artist login
if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = "Charizk";
}

$artist_id = $_SESSION['user_id'];
$artist_name = $_SESSION['user_name'];

// Handle music upload
if(isset($_POST['upload'])){
    $title = $conn->real_escape_string($_POST['title']);

    // Artwork
    $artwork_name = time().'_'.basename($_FILES['artwork']['name']);
    $artwork_path = 'uploads/artwork/'.$artwork_name;
    move_uploaded_file($_FILES['artwork']['tmp_name'],$artwork_path);

    // Music
    $music_name = time().'_'.basename($_FILES['music']['name']);
    $music_path = 'uploads/music/'.$music_name;
    move_uploaded_file($_FILES['music']['tmp_name'],$music_path);

    $conn->query("INSERT INTO music (artist_id,title,artwork,music_file,uploaded_at) VALUES ('$artist_id','$title','$artwork_path','$music_path',NOW())");
    header("Location: artist_dashboard.php");
    exit;
}

// Handle delete
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT artwork,music_file FROM music WHERE id=$id AND artist_id=$artist_id");
    if($res->num_rows){
        $row = $res->fetch_assoc();
        if(file_exists($row['artwork'])) unlink($row['artwork']);
        if(file_exists($row['music_file'])) unlink($row['music_file']);
        $conn->query("DELETE FROM music WHERE id=$id AND artist_id=$artist_id");
    }
    header("Location: artist_dashboard.php");
    exit;
}

// Fetch artist stats
$songs_count = $conn->query("SELECT COUNT(*) as c FROM music WHERE artist_id=$artist_id")->fetch_assoc()['c'];
$downloads_count = $conn->query("SELECT SUM(downloads) as d FROM music WHERE artist_id=$artist_id")->fetch_assoc()['d'] ?? 0;
$likes_count = $conn->query("SELECT SUM(likes) as l FROM music WHERE artist_id=$artist_id")->fetch_assoc()['l'] ?? 0;

// Fetch music library
$music_res = $conn->query("SELECT * FROM music WHERE artist_id=$artist_id ORDER BY uploaded_at DESC");

// For charts: monthly downloads & likes
$chart_res = $conn->query("SELECT MONTH(uploaded_at) as month, SUM(downloads) as downloads, SUM(likes) as likes FROM music WHERE artist_id=$artist_id GROUP BY MONTH(uploaded_at)");
$downloads = $likes = array_fill(1,12,0);
while($row=$chart_res->fetch_assoc()){
    $downloads[intval($row['month'])] = intval($row['downloads']);
    $likes[intval($row['month'])] = intval($row['likes']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Artist Dashboard -TRICK-TUNES</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="bg-slate-900 text-slate-100 font-sans min-h-screen">

<header class="sticky top-0 z-50 bg-gradient-to-r from-indigo-600 to-purple-600 shadow-md">
  <div class="container mx-auto flex items-center justify-between px-6 py-4">
    <h1 class="text-xl font-bold">🎵 Artist Dashboard</h1>
    <div class="hidden md:flex space-x-4">
      <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-cyan-500 hover:bg-cyan-400 px-4 py-2 rounded-lg shadow transition"><i class="fa fa-upload"></i> Upload</button>
      <a href="logout.php" class="bg-rose-500 hover:bg-rose-400 px-4 py-2 rounded-lg shadow transition"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
</header>

<main class="container mx-auto px-6 py-10 space-y-10">

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
  <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
    <i class="fa fa-users text-3xl text-indigo-400"></i>
    <div>
      <h2 class="text-2xl font-bold" id="artistCount">120</h2>
      <p class="text-slate-400">Fans</p>
    </div>
  </div>
  <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
    <i class="fa fa-music text-3xl text-cyan-400"></i>
    <div>
      <h2 class="text-2xl font-bold" id="songCount"><?= $songs_count ?></h2>
      <p class="text-slate-400">Songs</p>
    </div>
  </div>
  <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
    <i class="fa fa-download text-3xl text-emerald-400"></i>
    <div>
      <h2 class="text-2xl font-bold" id="downloadCount"><?= number_format($downloads_count) ?></h2>
      <p class="text-slate-400">Downloads</p>
    </div>
  </div>
  <div class="bg-slate-800 rounded-xl shadow-lg p-6 flex items-center space-x-4 hover:scale-105 transition">
    <i class="fa fa-heart text-3xl text-rose-400"></i>
    <div>
      <h2 class="text-2xl font-bold" id="likeCount"><?= number_format($likes_count) ?></h2>
      <p class="text-slate-400">Likes</p>
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
<div class="overflow-x-auto animate__animated animate__fadeInUp">
  <h3 class="text-lg font-semibold mb-4">Music Library</h3>
  <table id="musicTable" class="w-full text-left border-collapse rounded-lg overflow-hidden">
    <thead class="bg-slate-800 text-slate-300 uppercase text-sm">
      <tr><th class="p-3">Artwork</th><th class="p-3">Title</th><th class="p-3">Music</th><th class="p-3 text-center">Actions</th></tr>
    </thead>
    <tbody>
      <?php while($music=$music_res->fetch_assoc()): ?>
      <tr class="odd:bg-slate-800 even:bg-slate-700 hover:bg-slate-600 transition">
        <td class="p-3"><img src="<?= $music['artwork'] ?>" class="w-16 h-16 object-cover rounded-lg"></td>
        <td class="p-3 font-semibold"><?= htmlspecialchars($music['title']) ?></td>
        <td class="p-3"><audio controls class="w-48"><source src="<?= $music['music_file'] ?>" type="audio/mpeg"></audio></td>
        <td class="p-3 flex justify-center space-x-3">
          <a href="edit_music.php?id=<?= $music['id'] ?>" class="bg-indigo-500 hover:bg-indigo-400 p-2 rounded-lg"><i class="fa fa-edit"></i></a>
          <a href="?delete=<?= $music['id'] ?>" class="bg-rose-500 hover:bg-rose-400 p-2 rounded-lg"><i class="fa fa-trash"></i></a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</main>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">
  <div class="bg-slate-800/80 rounded-2xl shadow-2xl p-8 w-full max-w-lg animate__animated animate__zoomIn">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold">Upload Music</h2>
      <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-slate-400 hover:text-white"><i class="fa fa-times text-xl"></i></button>
    </div>
    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <div><label class="block mb-1 font-semibold">Upload Artwork</label><input type="file" name="artwork" accept="image/*" required class="w-full px-3 py-2 rounded-lg bg-slate-900/60 text-slate-100"></div>
      <div><label class="block mb-1 font-semibold">Upload Music</label><input type="file" name="music" accept="audio/*" required class="w-full px-3 py-2 rounded-lg bg-slate-900/60 text-slate-100"></div>
      <div><label class="block mb-1 font-semibold">Music Title</label><input type="text" name="title" required class="w-full px-3 py-2 rounded-lg bg-slate-900/60 text-slate-100"></div>
      <div class="flex justify-end space-x-4 pt-4">
        <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="bg-rose-500 hover:bg-rose-400 px-4 py-2 rounded-lg">Cancel</button>
        <button type="submit" name="upload" class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg">Upload</button>
      </div>
    </form>
  </div>
</div>

<script>
new Chart(document.getElementById('downloadsChart'),{
  type:'line',
  data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{label:'Downloads',data:<?= json_encode(array_values($downloads)) ?>,borderColor:'#22d3ee',backgroundColor:'#22d3ee33',fill:true,tension:0.3}]},
  options:{plugins:{legend:{labels:{color:'white'}}},scales:{x:{ticks:{color:'white'}},y:{ticks:{color:'white'}}}}
});
new Chart(document.getElementById('likesChart'),{
  type:'bar',
  data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{label:'Likes',data:<?= json_encode(array_values($likes)) ?>,backgroundColor:'#f43f5e'}]},
  options:{plugins:{legend:{labels:{color:'white'}}},scales:{x:{ticks:{color:'white'}},y:{ticks:{color:'white'}}}}
});
</script>

</body>
</html>
