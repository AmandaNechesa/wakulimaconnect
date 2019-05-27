<?php
include "dbconnector.php";
session_destroy();
if (isset($_GET['homepage'])) {
    header('Location:../index.php?logged out');

} else {
    header('Location:index.php?logged out');
}