<?php
include 'koneksi.php';
$date_today = date('Y-m-d');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kegiatan = $_POST['kegiatan'];
    $tanggal = $_POST['tanggal'];
    $koneksi->query("INSERT INTO todo (kegiatan, tanggal, status) VALUES ('$kegiatan', '$tanggal', 0)");
}
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    $koneksi->query("UPDATE todo SET status = 1 WHERE id = '$id'");
    header("Location: index.php");
    exit;
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $koneksi->query("DELETE FROM todo WHERE id = '$id'");
    header("Location: index.php");
    exit;
}
$todos = $koneksi->query("SELECT * FROM todo WHERE tanggal = '$date_today' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>TeddyTasks 💗</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
    background: #FFF0F5;
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #D36E70;
    margin: 0;
    padding: 20px;
    background-image: url('https://i.ibb.co/xSXKgMZ/pink-bear-bg.png');
    background-size: 80px;
    background-repeat: repeat;
}
.container {
    max-width: 600px;
    margin: auto;
    background: #FFEAF1;
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(200, 100, 150, 0.2);
}
h1 {
    text-align: center;
    color: #C94F7C;
    font-size: 28px;
    margin-bottom: 20px;
}
form input, form button {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: none;
    border-radius: 12px;
    font-size: 16px;
}
form input {
    background: #FFF6F9;
}
form button {
    background-color: #F06292;
    color: white;
    cursor: pointer;
    transition: 0.3s ease;
}
form button:hover {
    background-color: #D81B60;
}
.todo-list {
    list-style: none;
    padding: 0;
    margin-top: 20px;
}
.todo-list li {
    background: #FFF6F9;
    border-radius: 12px;
    padding: 12px 15px;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.todo-list li.selesai {
    text-decoration: line-through;
    color: #AAA;
}
.aksi a {
    text-decoration: none;
    margin-left: 10px;
    font-size: 18px;
}
a.selesai-btn {
    color: #66BB6A;
}
a.hapus-btn {
    color: #EF5350;
}
.bear-emoji {
    font-size: 40px;
    text-align: center;
    margin-bottom: 10px;
}
</style>
<body>
<div class="container">
    <div class="bear-emoji">🐻💗</div>
    <h1>📋 TeddyTask - To Do List Harianmu</h1>
    <form method="POST">
        <label>🌸 Apa kegiatanmu hari ini?</label>
        <input type="text" name="kegiatan" placeholder="Contoh: Belajar..." required>
        <input type="date" name="tanggal" value="<?= $date_today ?>" required>
        <button type="submit">➕ Tambah Kegiatan</button>
    </form>
    <ul class="todo-list">
        <?php while ($row = $todos->fetch_assoc()): ?>
            <li class="<?= $row['status'] ? 'selesai' : '' ?>">
                <?= htmlspecialchars($row['kegiatan']) ?>
                <div class="aksi">
                    <?php if (!$row['status']): ?>
                        <a class="selesai-btn" href="?done=<?= $row['id'] ?>">✅</a>
                    <?php endif; ?>
                    <a class="hapus-btn" href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus kegiatan ini? 🐻💧')">🗑️</a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
</body>
</html>
