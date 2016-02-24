<?php
include_once("../connection.php");
session_destroy();
unset($_SESSION);
header("Location: index.php");
exit();