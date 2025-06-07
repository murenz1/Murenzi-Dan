<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';
$error = '';
$success = '';
if (isset($_POST['add'])) {
    try {
        $tittle = $_POST['tittle'];
        $auther = $_POST['auther'];
        $year = $_POST['publication_year'];
        $stmt = $conn->prepare('INSERT INTO books (tittle, auther, publication_year) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $tittle, $auther, $year);
        $stmt->execute();
        $success = 'Book added successfully!';
    } catch (Exception $e) {
        $error = 'Failed to add book.';
    }
}
if (isset($_POST['update'])) {
    try {
        $id = $_POST['id'];
        $tittle = $_POST['tittle'];
        $auther = $_POST['auther'];
        $year = $_POST['publication_year'];
        $stmt = $conn->prepare('UPDATE books SET tittle=?, auther=?, publication_year=? WHERE id=?');
        $stmt->bind_param('ssii', $tittle, $auther, $year, $id);
        $stmt->execute();
        $success = 'Book updated successfully!';
    } catch (Exception $e) {
        $error = 'Failed to update book.';
    }
}
if (isset($_GET['delete'])) {
    try {
        $id = $_GET['delete'];
        $stmt = $conn->prepare('DELETE FROM books WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = 'Book deleted successfully!';
    } catch (Exception $e) {
        $error = 'Failed to delete book.';
    }
}
$result = $conn->query('SELECT * FROM books');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fa; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 2em 2.5em; border-radius: 10px; box-shadow: 0 2px 10px #0001; }
        h2 { color: #333; }
        form { display: flex; gap: 1em; align-items: center; margin-bottom: 1.5em; }
        input[type="text"], input[type="number"] { padding: 0.5em; border: 1px solid #bbb; border-radius: 5px; font-size: 1em; }
        input[type="submit"] { background: #007bff; color: #fff; border: none; padding: 0.6em 1.2em; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background 0.2s; }
        input[type="submit"]:hover { background: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 1em; }
        th, td { padding: 0.7em; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f0f0f0; }
        tr:nth-child(even) { background: #fafbfc; }
        .actions { display: flex; gap: 0.5em; }
        .error { background: #c00; color: #fff; padding: 0.7em; border-radius: 5px; margin-bottom: 1em; text-align: center; }
        .success { background: #28a745; color: #fff; padding: 0.7em; border-radius: 5px; margin-bottom: 1em; text-align: center; }
        .logout-link { float: right; }
        .logout-link a { color: #007bff; text-decoration: none; }
        .logout-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <div class="logout-link"><a href="logout.php">Logout</a></div>
    <h2>Books CRUD</h2>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="tittle" placeholder="Title" required>
        <input type="text" name="auther" placeholder="Author" required>
        <input type="number" name="publication_year" placeholder="Year" required>
        <input type="submit" name="add" value="Add">
    </form>
    <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="post">
            <td><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"></td>
            <td><input type="text" name="tittle" value="<?= htmlspecialchars($row['tittle']) ?>"></td>
            <td><input type="text" name="auther" value="<?= htmlspecialchars($row['auther']) ?>"></td>
            <td><input type="number" name="publication_year" value="<?= $row['publication_year'] ?>"></td>
            <td class="actions">
                <input type="submit" name="update" value="Update">
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this book?')" style="color:#c00;">Delete</a>
            </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
