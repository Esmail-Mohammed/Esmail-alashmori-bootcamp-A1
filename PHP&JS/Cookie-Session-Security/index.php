

<?php



$is_secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $is_secure,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

if (isset($_GET['login'])) {
    session_regenerate_id(true);
    $_SESSION['logged_in'] = true;
}

setcookie('protected_demo', 'protected value', [
    'expires' => time() + 3600,
    'path' => '/',
    'secure' => $is_secure,
    'httponly' => true,
    'samesite' => 'Strict'
]);

setcookie('unprotected_demo', 'demo value', [
    'expires' => time() + 3600,
    'path' => '/',
    'secure' => false,
    'httponly' => false,
    'samesite' => 'Lax'
]);

header('Content-Type: text/html; charset=utf-8');
$login_text = isset($_SESSION['logged_in']) ? 'Login complete' : 'Not logged in';
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Session and Cookie </title>
</head>
<body>
<h1>Session and Cookie </h1>
<p><?php echo htmlspecialchars($login_text, ENT_QUOTES, 'UTF-8'); ?></p>
<p><a href="?login=1">Run mock login and renew session ID</a></p>
<p>Protected cookie: HttpOnly and SameSite Strict<?php echo $is_secure ? ', Secure' : ', Secure is enabled only over HTTPS'; ?></p>
<p>Unprotected demo cookie: HttpOnly is off and SameSite is Lax</p>
<p>The unprotected cookie is only for comparison and must not be used for authentication.</p>
<button id="checkCookies">Check cookies from JavaScript</button>
<p id="cookieOutput"></p>
<script>
document.getElementById('checkCookies').addEventListener('click', function () {
    document.getElementById('cookieOutput').textContent = document.cookie || 'No JavaScript-readable cookies';
});
</script>
</body>
</html>