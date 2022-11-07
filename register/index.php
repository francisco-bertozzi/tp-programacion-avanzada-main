<?php include_once "../includes/header.php" ?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["registerError"])) {
    $errorMsg = $_SESSION["registerError"];
    unset($_SESSION["registerError"]);
}

if (isset($_SESSION["registerSuccessful"])) {
    $registerSuccessful = true;
    unset($_SESSION["registerSuccessful"]);
}

?>

<main class="container" style="max-width: 720px;">
    <article style="margin-top: 0;">
        <h3>Registrate en amaclon!</h3>
        <form action="./registerProcess.php" method="post">
            <label>
                Nuevo nombre de usuario:
                <input type="text" 
                    name="username" 
                    required 
                    minlength="3" 
                    autocapitalize="none"/>
            </label>
            <label>
                Email:
                <input type="text" 
                    name="email"
                    required
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                    title="Must be a valid email address"
                    autocapitalize="none" />
            </label>
            <label>
                Contraseña:
                <input type="password" 
                    name="password"
                    required
                    minlength="6" />
            </label>
            <label>
                Repetir contraseña:
                <input type="password" 
                    name="passwordRepeated"
                    required
                    minlength="6" />
            </label>
    
            <?php if (isset($errorMsg)): ?>
            <small class="warning"><?php echo $errorMsg; ?></small>
            <?php endif; ?>
            
            <button type="submit">Registrarse</button>
        </form>
    </article>

    <?php if (isset($registerSuccessful)): ?>
    <dialog open>
        <article>
            <h4>Tu registro fue procesado correctamente!</h4>
            <footer>
            <a id="closeModal" href="#cancel" role="button" class="secondary">Cancelar</a>
            <a href="../login/" role="button">Loguearse</a>
            </footer>
        </article>
    </dialog>
    <?php endif; ?>
</main>

<script src="../js/login.js"></script>
<script>

const modal = document.querySelector("dialog")
const btnCloseModal = document.querySelector("#closeModal")

btnCloseModal.addEventListener("click", () => {
    modal.removeAttribute("open");
})

</script>

<?php include_once "../includes/footer.php" ?>