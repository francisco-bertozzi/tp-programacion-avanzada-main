<?php include_once "../includes/header.php" ?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"])) {
    header('Location: ../login/');
    exit();
} else {
    $username = $_SESSION["user"]["username"];
}

include_once "../includes/db.php";

$dbInstance = DB::getInstance();
$conn = $dbInstance->getConnection();

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $searchVar = "%" . $search . "%";
    
    $sql = "SELECT 
        p.title, p.price, c.name, u.email 
    FROM 
        products p 
    INNER JOIN 
        categories c ON c.id = p.category_id 
    INNER JOIN 
        users u ON p.published_by = u.id 
    WHERE 
        p.title LIKE ? 
    ORDER BY p.published_at 
    LIMIT 15";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchVar);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $sql = "SELECT 
            p.title, p.price, c.name, u.email 
        FROM 
            products p 
        INNER JOIN 
            categories c ON c.id = p.category_id 
        INNER JOIN 
            users u ON p.published_by = u.id
        ORDER BY p.published_at 
        LIMIT 15";
    
    $result = $conn->query($sql);
}


if ($result) {
    while ($data = $result->fetch_assoc()) {
        $products[] = [
            "title" => $data["title"],
            "price" => $data["price"],
            "category" => $data["name"],
            "email" => $data["email"]
        ];
    }
}

?>

<main class="container" style="padding-top: .5rem;">
    <form action="." method="get">
        <input type="search" id="search" name="search" placeholder="Search">
        <button type="submit">Buscar</button>
    </form>
    <?php if (isset($search)): ?>
    <h4 style="margin: .5rem 0;">Resultados de la búsqueda <?php echo $search; ?>:</h4>
    <?php else: ?>
    <h4 style="margin: .5rem 0;">Últimos productos añadidos:</h4>
    <?php endif; ?>
    <div class="products-container">
        <?php
        
        if (isset($products)) {
            foreach ($products as $product) {
                $title = $product["title"];
                $price = $product["price"];
                $email = $product["email"];
                echo "
                    <article class='grid' style='gap: 0;'>
                        <div class='img-container'>
                            <img class='category-img' src='https://placekitten.com/g/350/200' alt='category image'>
                        </div>
                        <div style='padding: 1rem;'>
                            <p>
                                <b>$title</b>
                            </p>
                            <p>
                                $ $price
                            </p>
                            <a style='width: 100%;' href='mailto:$email?subject=Product%20$title%20on%20Amaclon' role='button'>Contactar</a>
                        </div>
                    </article>";
            }   
        } else {
            echo "<p>No hay productos 😢</p>";
        }


        ?>
    </div>
</main>

<style>
.products-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(min(21rem, 100%), 1fr));
    gap: 1rem;
}

.products-container article {
    margin: 0;
    padding: 0;
}

.img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    border-radius: 5px 0 0 5px;
}

.category-img {
    flex-shrink: 0;
    min-width: 100%;
    min-height: 100%;
    max-width: fit-content;
    overflow: hidden;
}

form {
    display: flex;
    margin-bottom: 0;
}
form button {
    flex: 1;
    margin-left: -50px;
    max-width: 12ch;
    border-radius: 0 2rem 2rem 0;
}
</style>
<?php include_once "../includes/footer.php" ?>
