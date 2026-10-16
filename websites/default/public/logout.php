<?php
require 'session.php';

// Destroy the session and send the user back to login
session_destroy();
header('Location: /login.php');
exit;
