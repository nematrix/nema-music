<?php
session_start();
include 'config.php';

// REGISTER HANDLER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $conn->real_escape_string($_POST['role']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $_SESSION['error'] = "Passwords do not match.";
    } else {
        $check = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            $_SESSION['error'] = "Email already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (role, name, email, password) VALUES ('$role', '$name', '$email', '$hashed')";
            if ($conn->query($sql)) {
                $_SESSION['success'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit;
            } else {
                $_SESSION['error'] = "Registration failed. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - TRICK-TUNES</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 flex justify-center items-center h-screen">
<div class="bg-slate-800 p-8 rounded-xl w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
    <?php 
    if(isset($_SESSION['error'])) { echo "<p class='text-red-500 mb-3'>{$_SESSION['error']}</p>"; unset($_SESSION['error']); } 
    ?>
    <form action="" method="POST" class="space-y-4">
        <select name="role" required class="w-full bg-slate-900 text-slate-100 px-3 py-2 rounded-lg">
            <option value="">-- Register As --</option>
            <option value="admin">Admin</option>
            <option value="artist">Artist</option>
            <option value="user">User</option>
        </select>
        <input type="text" name="name" placeholder="Full Name" required class="w-full px-3 py-2 rounded-lg bg-slate-900 text-slate-100">
        <input type="email" name="email" placeholder="Email" required class="w-full px-3 py-2 rounded-lg bg-slate-900 text-slate-100">
        <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 rounded-lg bg-slate-900 text-slate-100">
        <input type="password" name="confirm" placeholder="Confirm Password" required class="w-full px-3 py-2 rounded-lg bg-slate-900 text-slate-100">
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-2 rounded-lg text-white">Register</button>
    </form>
    <p class="mt-4 text-center text-slate-300">Already have an account? <a href="login.php" class="text-cyan-400">Login</a></p>
</div>
</body>
</html>
