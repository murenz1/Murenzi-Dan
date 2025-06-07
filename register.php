<?php
include 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $password);
        if ($stmt->execute()) {
            echo '<div class="success">Registration successful. <a href="login.php">Login here</a></div>';
        } else {
            $error = 'Registration failed.';
        }
    } catch (Exception $e) {
        $error = 'An error occurred. Please try again later.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fa; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; padding: 2em 2.5em; border-radius: 10px; box-shadow: 0 2px 10px #0001; }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; gap: 1em; }
        input[type="text"], input[type="password"] { padding: 0.7em; border: 1px solid #bbb; border-radius: 5px; font-size: 1em; }
        input[type="submit"] { background: #007bff; color: #fff; border: none; padding: 0.8em; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background 0.2s; }
        input[type="submit"]:hover { background: #0056b3; }
        .error { background: #c00; color: #fff; padding: 0.7em; border-radius: 5px; margin-bottom: 1em; text-align: center; }
        .success { background: #28a745; color: #fff; padding: 0.7em; border-radius: 5px; margin-bottom: 1em; text-align: center; }
        .login-link { text-align: center; margin-top: 1em; }
        .login-link a { color: #007bff; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </form>
    <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>
</body>
</html>
