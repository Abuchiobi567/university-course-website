<?php
// Secure the session cookie before starting the session
ini_set('session.save_path', '/tmp');
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
session_start();
