<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Yubikey Test</title>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div>
		<a href="/login">Login</a>
		<a href="/register">Register</a>
	</div>

	<p class="footer"><?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
