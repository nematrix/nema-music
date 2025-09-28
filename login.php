<?php
session_start();
include 'config.php';

// LOGIN HANDLER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $conn->real_escape_string($_POST['role']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $sql = "SELECT * FROM users WHERE email='$email' AND role='$role' LIMIT 1";
    $result = $conn->query($sql);

   if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($remember) {
            $token = bin2hex(random_bytes(16));
            $conn->query("UPDATE users SET token='$token' WHERE id={$user['id']}");
            setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
            setcookie('user_token', $token, time() + (86400 * 30), "/");
        }

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: dashboard.php");
            exit;
        } elseif ($user['role'] === 'artist') {
            header("Location: artist_dashbord.php");
            exit;
        } else {
            header("Location: index.php"); // regular user goes to home page
            exit;
        }
    } else {
        $_SESSION['error'] = "Incorrect password.";
    }
} else {
    $_SESSION['error'] = "User not found.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - TRICK-TUNES</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 flex justify-center items-center h-screen">
<div class="bg-slate-800 p-8 rounded-xl w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <?php if(isset($_SESSION['error'])) { echo "<p class='text-red-500 mb-3'>{$_SESSION['error']}</p>"; unset($_SESSION['error']); } ?>
    <form action="" method="POST" class="space-y-4">
        <select name="role" required class="w-full bg-slate-900 text-slate-100 px-3 py-2 rounded-lg">
            <option value="">-- Login As --</option>
            <option value="admin">Admin</option>
            <option value="artist">Artist</option>
            <option value="user">User</option>
        </select>
        <input type="email" name="email" placeholder="Email" required class="w-full px-3 py-2 rounded-lg bg-slate-900 text-slate-100">
        <input type="password" name="password" placeholder="Password" required class="w-full px-3 py-2 rounded-lg bg-slate-900 text-slate-100">
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="remember" id="remember" class="accent-cyan-500">
            <label for="remember" class="text-slate-300">Remember Me</label>
        </div>
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-2 rounded-lg text-white">Login</button>
    </form>
    <p class="mt-4 text-center text-slate-300">Don't have an account? <a href="register.php" class="text-cyan-400">Register</a></p>
</div>
</body>
</html>
