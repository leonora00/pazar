<?php
session_start();
$msg = "";
include_once 'functions.php';
include_once 'app/config/config.php';
$content = array_search(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $routes);
$pageSlug = (!empty($content)) ?  basename($content, ".php") . PHP_EOL : false;
$title = array_search(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $titles);
if (!isset($_SESSION["cart"])) $_SESSION["cart"] = generateRandomString(20, true);
include 'header.php';
include (!empty($content)) ? $content : '404.php';
include 'footer.php';
