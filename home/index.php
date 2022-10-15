<?php include_once "../includes/header.php" ?>

<?php
session_start();

if (!isset($_SESSION["username"])) {
    header('Location: ../login/');
} else {
    $username = $_SESSION["username"];
}
?>

<main class="container " style="text-align: center;">
    <article class="grid" style="padding: 0; overflow: hidden; background-image: linear-gradient(280deg, #bf90f2 0, #8f6cd8 50%, #594bbf 100%);">
        <div style="padding: 2rem ;">
             <h2 style="margin-top: 7rem">BIENVENIDO A AMACLON, <?php echo $username ?>!</h2>
             <h4 >Una nueva forma de vender y comprar.</h4>
         </div>
        <div>
        <img src="../img/123.png">
        </div>  
    </article>
</main>

<?php include_once "../includes/footer.php" ?>
