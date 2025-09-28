<?php
session_start();
$error = "";
$success = "";

// MySQLi connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nema-music";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $conn->real_escape_string($_POST['name']);
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Check if email exists
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed')");
            $success = "Registration successful! You can now <a href='login.php' class='text-cyan-400 underline'>login</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TRICK-TUNES  - Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="h-screen w-full bg-gradient-to-r from-slate-900 via-indigo-900 to-purple-900 flex items-center justify-center">

  <div class="grid md:grid-cols-2 w-full h-full">

    <!-- Left Image -->
    <div class="hidden md:flex items-center justify-center bg-cover bg-center animate__animated animate__fadeInLeft"
         style="background-image: url('images/8.jpeg');">
    </div>

    <!-- Right Form -->
    <div class="flex items-center justify-center p-6">
      <div class="w-full max-w-md bg-slate-800/60 backdrop-blur-md rounded-2xl shadow-xl p-8 text-center animate__animated animate__fadeInRight">

        <!-- Logo -->
        <div class="mb-6">
          <img src="images/logo.jpg" alt="Logo" class="mx-auto w-24 rounded-full shadow-lg">
        </div>

        <!-- Heading -->
        <h2 class="text-2xl font-bold mb-6">Create Your Account</h2>

        <!-- Error / Success Messages -->
        <?php if($error): ?>
          <div class="bg-rose-500/80 text-white py-2 px-4 rounded mb-4"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
          <div class="bg-emerald-500/80 text-white py-2 px-4 rounded mb-4"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Form -->
        <form action="" method="POST" class="space-y-4 text-left">
          <!-- Full Name -->
          <div class="relative">
            <i class="fa fa-user absolute left-3 top-3 text-slate-400"></i>
            <input type="text" name="name" placeholder="Full Name" required
                   class="w-full pl-10 pr-3 py-2 rounded-lg bg-slate-900/60 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

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

          <!-- Confirm Password -->
          <div class="relative group">
            <i class="fa fa-lock absolute left-3 top-3 text-slate-400"></i>
            <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirmPassword" required
                   class="w-full pl-10 pr-10 py-2 rounded-lg bg-slate-900/60 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <i class="fa fa-eye absolute right-3 top-3 text-slate-400 cursor-pointer opacity-0 group-hover:opacity-100 transition"
               onclick="togglePassword('confirmPassword', this)"></i>
          </div>

          <!-- Submit -->
          <button type="submit"
                  class="w-full bg-indigo-600 hover:bg-indigo-500 transition text-white font-semibold py-2 rounded-lg shadow-md">
            Register
          </button>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-slate-300">
          Already have an account?
          <a href="login.php" class="text-cyan-400 hover:underline">Login here</a>
        </p>
      </div>
    </div>
  </div>

  <!-- JavaScript for Show/Hide Password -->
  <script>
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
