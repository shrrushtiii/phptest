<?php
include "db.php";

$uid = $_SESSION["uid"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $title = $_POST["title"];
    $author = $_POST["author"];
    $isbn = $_POST["isbn"];
    $category = $_POST["category"];
    $price = $_POST["price"];

    $sql = $conn->prepare(
        "update products set title=?, author=?, isbn=?, category=? ,price=?where bid=? AND uid=?"
    );

    $sql->bind_param(
        
       "ssdisi",
        $title,
        $author,
        $isbn,
        $category,
        $price,
        $uid
    );

    if ($sql->execute()) {
        header("Location: home.php");
        exit();
    }
}

// Fetch product details
if (isset($_GET["bid"])) {

    $pid = $_GET["bid"];

    $sql = $conn->prepare(
        "select bid, title,author ,isbn, category,price from books where bid=? and uid=?");

    $sql->bind_param("ii", $bid, $uid);
    $sql->execute();

    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "book not found";
        exit();
    }

} else {
    echo "book ID is missing";
    exit();
}
?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Edit book</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
</head>

<body>

<main>

    <h1 class="text-center m-5">EDIT PRODUCT</h1>

    <div class="container col-5 border rounded shadow mt-4 p-3">

        <form action="" method="POST">

            <input
                type="hidden"
                name="pid"
                value="<?php echo $row["pid"]; ?>"
            >

            <div class="mb-3">
                <label class="form-label">BOOK TITLE</label>

                <input
                    type="text"
                    class="form-control"
                    name="title"
                    value="<?php echo $row["title"]; ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">AUTHOR</label>

                <input
                    type="text"
                    class="form-control"
                    name="author"
                    value="<?php echo $row["author"]; ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN NUMBER</label>

                <input
                    type="number"
                    class="form-control"
                    name="isbn"
                    value="<?php echo $row["isbn"]; ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">CATEGORY</label>

                <input
                    type="number"
                    class="form-control"
                    name="category"
                    value="<?php echo $row["category"]; ?>"
                >
            </div>
             <div class="mb-3">
                <label class="form-label">PRICE</label>

                <input
                    type="number"
                    class="form-control"
                    name="price"
                    value="<?php echo $row["price"]; ?>"
                >
            </div>

            <button
                type="submit"
                class="btn btn-primary"
               
            >
                Update Product
            </button>

        </form>

    </div>

</main>

</body>
</html>