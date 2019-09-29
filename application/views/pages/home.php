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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-4">
            <h1>Yubikey register/login demo</h1>
            <br>
            <div class="lead">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="/login">
                            <span class="fas fa-sign-in-alt"></span>
                            Login
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="/register">
                            <span class="fas fa-user-plus"></span>
                            Register
                        </a>
                    </li>
                </ul>
            </div>
            <br>
            <div>
                <small><?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version ' . CI_VERSION : '' ?></small>
            </div>
        </div>
    </div>
</div>

</body>
</html>
