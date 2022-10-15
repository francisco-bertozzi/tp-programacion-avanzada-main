<?php
include_once "../includes/header.php";
?>

<?php

session_start();

if(isset($_SESSION["username"])) {
    header("Location: ../");
}

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
                data-sitekey="6LfISmYiAAAAAEvJJKk9Dz1qlC1Wi7NXkqxBo1bk"
                
                ></div>
            
                <?php if($errorMsg): ?>
                    <div style='margin-bottom: 1rem;'><small class='warning'><?php echo $errorMsg ?></small></div>
                <?php endif; ?>
            
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="login-img"></div>    
    </article>
</main>
<script src="../js/login.js"></script>
<!-- HTML END -->

<?php
include_once "../includes/footer.php";
?>