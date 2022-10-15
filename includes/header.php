<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <!-- PICO.CSS -->
    <link rel="stylesheet" href="../css/pico.min.css">
    <!-- CUSTOM STYLES -->
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/themeSwitcher.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Amaclon</title>
</head>
<body>
    <nav class="container-fluid">
        <ul>
            <li>
                <strong style="font-size: 24px;">🛍️ Amaclon</strong>
            </li>
        </ul>
        <ul>
            <?php if ($username): ?>
            <li>
                <details role="list" dir="rtl">
                    <summary aria-haspopup="listbox" role="link"><b><?php echo $username ?></b></summary>
                    <ul role="listbox">
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </details>
            </li>
            <?php else: ?>
            <li>
                <b>
                    <a href="../login/">Login</a>
                </b>
            </li>
            <li>
                <b>
                    <a href="#">Register</a>
                </b>    
            </li>
            <?php endif; ?>
        </ul> 
    </nav>

    <button id="theme-switcher" class="contrast switcher"></button>
