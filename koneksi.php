<?php
// koneksi.php
$koneksi = new mysqli("localhost", "root", "", "db_todolist");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>