<?php
// Start the session and connect to the database
require_once __DIR__ . '/session.php';

$pdo = new PDO('mysql:host=mysql;dbname=v.je;charset=utf8', 'v.je', 'v.je');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
