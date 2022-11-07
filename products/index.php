<?php include_once "../includes/header.php" ?>

<?php
include_once "../includes/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbInstance = DB::getInstance();
$conn = $dbInstance->getConnection();

$userId = $_SESSION["user"]["id"];

$sql = "SELECT 
        p.id, p.title, p.description, p.price, c.name 
    FROM products p 
    INNER JOIN categories c 
    ON p.category_id = c.id 
    WHERE p.published_by = $userId";

$result = $conn->query($sql);

if ($result) {
    while ($data = $result->fetch_assoc()) {
        $products[] = [
            "title" => $data["title"],
            "description" => $data["description"],
            "price" => $data["price"],
            "category" => $data["name"],
            "id" => $data["id"]
        ];
    }
}

$result = $conn->query("SELECT id, name FROM categories");
if ($result) {
    while ($data = $result->fetch_assoc()) {
        $categories[] = [
            "name" => $data["name"],
            "id" => $data["id"] 
        ];
    }
}

?>

<main class="container">
    <button id="btnAddProduct">Add product</button>

    <h3>Mis productos</h3>
    <figure>
        <table role="grid" style="display: block; overflow-x: auto; white-space: no-wrap;" id="tabla">
            <?php if (!isset($products)): ?>
             <p>No tenés productos publicados :(</p>
             <?php else: ?>  
             <thead>
                 <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                 </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($products as $product) {
                      $title = $product["title"];
                     $description = $product["description"];
                     $price = $product["price"];
                     $category = $product["category"];
                     $id = $product["id"];
                    
                     $jsFunction = "openEditModal($id, \"$title\", \"$description\", $price, \"$category\")";
                    
                     echo "<tr>
                            <td>$title</td>
                            <td>$description</td>
                            <td>$ $price</td>
                            <td>$category</td>
                            <td>
                                <a href='#' onclick='$jsFunction' role='button' class='outline'><i class='fa-solid fa-pen-to-square'></i>Edit</a>
                                <a onclick='' class='warning contrast outline' href='./deleteProductProcess.php?id=$id' role='button' ><i class='fa-regular fa-trash-can'></i>Delete</a>
                             </td>
                         </tr>";
                }
            ?>
            </tbody>
        <?php endif; ?>
        </table>
    </figure>
    

    <dialog id="modalProduct">
        <article>
            <header style="padding-bottom: .5rem; margin-bottom: 1rem;">
                <a id="closeModalProduct" href="#" aria-label="Close" class="close"></a>
                <h3 style="margin-bottom: .5rem;">Añadir nuevo producto</h3>
            </header>
            <form action="./addProductProcess.php" method="post">
                <div class="grid">
                    <label>
                        Título
                        <input name="title" type="text" required />
                    </label>
                    <label>
                        Precio
                        <input name="price" type="number" step=".01" required />
                    </label>
                </div>
                <label>
                    Descripción
                    <textarea style="resize: none;" name="description" id="" cols="60" rows="5"></textarea>
                </label>
                <label>
                    Categoría
                    <select name="category" required>
                        <option value="" selected>Select a category…</option>
                            <?php
                            foreach ($categories as $category) {
                                $id = $category["id"];
                                $name = $category["name"];
                                echo "<option value=$id>$name</option>";
                            }                            
                            ?>
                    </select>
                </label>
                <div class="grid">
                    <button class="secondary" type="reset">Resetear</button>
                    <button type="submit">Agregar</button>
                </div>
            </form>
        </article>
    </dialog>

    <dialog id="modalEditProduct">
        <article>
            <header style="padding-bottom: .5rem; margin-bottom: 1rem;">
                <a id="closeModalProduct" href="#" aria-label="Close" class="close"></a>
                <h3 style="margin-bottom: .5rem;">Editando producto</h3>
            </header>
            <form action="./editProductProcess.php" method="post">
                <div class="grid">
                    <label>
                        Título
                        <input name="title" type="text" required />
                    </label>
                    <label>
                        Precio
                        <input name="price" type="number" step=".01" required />
                    </label>
                </div>
                <label>
                    Descripción
                    <textarea style="resize: none;" name="description" id="" cols="60" rows="5"></textarea>
                </label>
                <label>
                    Categoría
                    <select name="category" required>
                        <option value="" selected>Select a category…</option>
                            <?php
                            foreach ($categories as $category) {
                                $id = $category["id"];
                                $name = $category["name"];
                                echo "<option value=$id>$name</option>";
                            }                            
                            ?>
                    </select>
                </label>
                <div class="grid">
                    <button class="secondary" type="reset">Resetear</button>
                    <button type="submit">Editar</button>
                </div>
            </form>
        </article>
    </dialog>

</main>

<script>
    const buttonsClose = document.querySelectorAll("#closeModalProduct")
    const btnAddProduct = document.querySelector("#btnAddProduct")
    const modalProduct = document.querySelector("#modalProduct")
    const modalEditProduct = document.querySelector("#modalEditProduct")

    function openEditModal(id, title, description, price, category) {
        modalEditProduct.setAttribute("open", true)

        const form = modalEditProduct.querySelector("form")
        modalEditProduct.querySelector("input[name='title'").value = title
        modalEditProduct.querySelector("input[name='price'").value = price
        modalEditProduct.querySelector("textarea[name='description'").value = description
        const options = modalEditProduct.querySelectorAll("option")
        options.forEach(opt => {
            if (opt.getAttribute("value") === "") {
                opt.removeAttribute("selected")
            } else {
                if (opt.text === category) {
                    opt.setAttribute("selected", true)
                }
            }
        })

        const hiddenInput = document.createElement("input")
        hiddenInput.setAttribute("type", "hidden")
        hiddenInput.setAttribute("value", id)
        hiddenInput.setAttribute("name", "id")
        form.appendChild(hiddenInput)
    }

    btnAddProduct.addEventListener("click", () => {
        modalProduct.setAttribute("open", true)
    })

    buttonsClose.forEach((btn) => btn.addEventListener("click", () => {
        modalEditProduct.removeAttribute("open")
        modalProduct.removeAttribute("open")
    }))

</script>
<script>
    var tabla= document.querySelector("#tabla");
    var dataTable = new DataTable(tabla);
</script>
<?php include_once "../includes/footer.php" ?>