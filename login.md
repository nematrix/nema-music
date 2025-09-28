<?php
session_start();
include 'config.php'; // Database connection
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // admin, user, artist

    // Select table based on role
    switch($role){
        case 'admin': $table = 'admins'; break;
        case 'artist': $table = 'artists'; break;
        default: $table = 'users'; break;
    }

    $sql = "SELECT * FROM $table WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['role'] = $role;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'] ?? $user['username'];
            // Redirect to respective dashboard
            header("Location: {$role}/dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TRICK-TUNES - Login</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="h-screen w-full bg-gradient-to-r from-slate-900 via-indigo-900 to-purple-900 flex items-center justify-center">

<!-- Role Selection Modal -->
<div id="roleModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
  <div class="bg-slate-800 rounded-2xl p-8 w-80 text-center animate__animated animate__zoomIn">
    <h2 class="text-2xl font-bold mb-6">Login As</h2>
    <div class="space-y-4">
      <button onclick="setRole('admin')" class="w-full py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500">Admin</button>
      <button onclick="setRole('artist')" class="w-full py-2 rounded-lg bg-purple-600 hover:bg-purple-500">Artist</button>
      <button onclick="setRole('user')" class="w-full py-2 rounded-lg bg-cyan-600 hover:bg-cyan-500">User</button>
    </div>
  </div>
</div>

<!-- Login Form -->
<div class="w-full max-w-md bg-slate-800/60 backdrop-blur-md rounded-2xl shadow-xl p-8 text-center animate__animated animate__fadeInRight">

  <!-- Logo -->
  <div class="mb-6">
    <img src="images/logo.jpg" alt="Logo" class="mx-auto w-24 rounded-full shadow-lg">
  </div>

  <!-- Heading -->
  <h2 class="text-2xl font-bold mb-6" id="loginTitle">Login</h2>

  <!-- Error -->
  <?php if($error): ?>
    <div class="bg-rose-500/80 text-white py-2 px-4 rounded mb-4">
      <?php echo $error; ?>
    </div>
  <?php endif; ?>

  <!-- Form -->
  <form action="" method="POST" class="space-y-4 text-left">
    <input type="hidden" name="role" id="roleField" value="">

    <!-- Email -->
    <div class="relative">
      <i class="fa fa-envelope absolute left-3 top-3 text-slate-400"></i>
      <input type="email" name="email" placeholder="Email Address" required
             class="w-full pl-10 pr-3 py-2 rounded-lg bg-slate-900/60 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <!-- Password -->
    <div class="relative group">
      <i class="fa fa-lock absolute left-3 top-3 text-slate-400"></i>
      <input type="password" name="password" placeholder="Password" id="password" required
             class="w-full pl-10 pr-10 py-2 rounded-lg bg-slate-900/60 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      <i class="fa fa-eye absolute right-3 top-3 text-slate-400 cursor-pointer opacity-0 group-hover:opacity-100 transition"
         onclick="togglePassword('password', this)"></i>
    </div>

    <!-- Remember + Forgot -->
    <div class="flex items-center justify-between text-sm text-slate-300">
      <label class="flex items-center">
        <input type="checkbox" class="mr-2" name="remember">
        Remember Me
      </label>
      <a href="forget.php" class="hover:text-cyan-400">Forgot Password?</a>
    </div>

    <!-- Submit -->
    <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold py-2 rounded-lg shadow-md">
      Log In
    </button>
  </form>
</div>

<script>
  let selectedRole = '';
  const roleModal = document.getElementById('roleModal');
  const roleField = document.getElementById('roleField');
  const loginTitle = document.getElementById('loginTitle');

  function setRole(role){
    selectedRole = role;
    roleField.value = role;
    loginTitle.textContent = "Login as " + role.charAt(0).toUpperCase() + role.slice(1);
    roleModal.classList.add('hidden');
  }

  function togglePassword(fieldId, icon) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = "password";
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>

</body>
</html>
