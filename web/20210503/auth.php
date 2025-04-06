<?php
session_start();
if (!isset($_SESSION["LoginID"])) {
    header("Location: ../timeout.php");
    exit();
}
?>