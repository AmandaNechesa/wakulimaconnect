<?php
session_start();
session_destroy();
if (isset($_GET['homepage'])) {
    header('Location:../index.php?logged out');

} else {
    header('Location:index.php?logged out');
}