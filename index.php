<?php
$uname = $_COOKIE['Username'] ?? 0;
$passw = $_COOKIE['auth'] ?? 0;
if (!$uname || !$passw) { header('location: login/'); }
?>