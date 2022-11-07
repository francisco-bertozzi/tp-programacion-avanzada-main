<?php
include_once "../includes/header.php";
?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["username"])) {
    header("Location: ../");
    exit();
}

$token = bin2hex(random_bytes(16));
$_SESSION["token"] = $token;

if (isset($_SESSION["loginError"])) {
    $errorMsg = $_SESSION["loginError"];
    unset($_SESSION["loginError"]);
}

?>

<!-- HTML START -->

<main class="container login-main">
    <article class="grid" style="padding: 0; overflow: hidden;">
        <div style="padding: 2rem;">
            <hgroup>
                <h2>Login</h2>
                <h2>Hello! Welcome Back</h2>
            </hgroup>
            <form method="POST" action="./procesoLogin.php">
                <label>
                    Username:
                    <input type="text"
                        name="username"
                        minlength="3"
                        autocapitalize="none"
                        required />
                </label>
                <label>
                    Password:
                    <input type="password"
                        name="password"
                        minlength="6"
                        required />
                </label>
                
                <div class="g-recaptcha"
                    style="margin-bottom: 1rem;" 
                    data-sitekey="6LfISmYiAAAAAEvJJKk9Dz1qlC1Wi7NXkqxBo1bk"></div>
                
                <input type="hidden" name="token" value=<?php echo $token; ?> />
                
                <?php if(isset($errorMsg)): ?>
                <div style='margin-bottom: 1rem;'><small class='warning'><?php echo $errorMsg ?></small></div>
                <?php endif; ?>
            
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="login-img"></div>    
    </article>
</main>
<script src="../js/login.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- HTML END -->

<?php
include_once "../includes/footer.php";
?>