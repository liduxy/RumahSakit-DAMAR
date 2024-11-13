<?php
session_start();
session_destroy(); // Hapus sesi
header("Location: index.php"); // Arahkan ke halaman login
exit();