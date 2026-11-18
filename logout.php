<?php
session_start();
session_destroy(); // M
header("Location: index.php"); // buat ngarahin lagi ke laman login
exit();
?>