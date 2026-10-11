<?php

session_start();
include "db.php";


if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION["id"];


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $isbn = $_POST["isbn"];
    $category = $_POST["category"];
    $price = $_POST["price"];

    
    $sql = $conn->prepare(
    "INSERT INTO books (title, author, isbn, category, price, uid)
     VALUES (?, ?, ?, ?, ?, ?)"
);

$sql->bind_param(
    "ssssdi",
    $title,
    $author,
    $isbn,
    $category,
    $price,
    $uid
);

$sql->execute();
    if ($sql->execute()) {
        echo "<script>
                alert('Book Added Successfully');
                window.location.href='home.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Book Not Added');
              </script>";
    }

    $sql->close();
}


$sql = $conn->prepare(
    "SELECT * FROM books WHERE uid = ?"
);

$sql->bind_param("i", $id);
$sql->execute();

$result = $sql->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Library Management System</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<!-- NAVBAR -->
<header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand fw-bold" href="home.php">
                Hello, <?php echo htmlspecialchars($_SESSION["uname"] ?? "user"); ?>
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">
                            Home
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2">

                    <a href="csv.php" class="btn btn-outline-primary">
                        Generate CSV
                    </a>

                    <a href="pdf.php" class="btn btn-outline-primary">
                        Generate PDF
                    </a>

                </div>
                <a
                    name=""
                    id=""
                    class="btn btn-primary"
                    href="logout.php"
                    role="button"
                    >logout</a
                >
                

            </div>
        </div>
    </nav>
</header>

<!-- ADD BOOK FORM -->
<main>

    <div class="container col-md-5 border rounded shadow mt-5 p-4">

        <h3 class="text-center mb-4">ADD BOOK</h3>

        <form action="" method="POST">

            <div class="mb-3">
                <label class="form-label">BOOK TITLE</label>

                <input
                    type="text"
                    class="form-control"
                    name="title"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">AUTHOR NAME</label>

                <input
                    type="text"
                    class="form-control"
                    name="author"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">ISBN NUMBER</label>

                <input
                    type="text"
                    class="form-control"
                    name="isbn"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">CATEGORY</label>

                <input
                    type="text"
                    class="form-control"
                    name="category"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">PRICE</label>

                <input
                    type="number"
                    class="form-control"
                    name="price"
                    step="0.01"
                    min="0"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Add Book
            </button>

        </form>

    </div>

    <!-- BOOK LIST -->

    <h1 class="text-center m-5">BOOK LIST</h1>

    <div class="container table-responsive">

        <table class="table table-bordered table-striped">

            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>TITLE</th>
                    <th>AUTHOR</th>
                    <th>ISBN NUMBER</th>
                    <th>CATEGORY</th>
                    <th>PRICE</th>
                    <th>EDIT</th>
                    <th>DELETE</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($row = $result->fetch_assoc()) { ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($row["bid"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["title"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["author"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["isbn"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["category"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["price"]); ?>
                        </td>

                        <td>
                            <a
                                class="btn btn-success btn-sm"
                                href="edit.php?pid=<?php echo urlencode($row["bid"]); ?>"
                            >
                                Edit
                            </a>
                        </td>

                        <td>
                            <a
                                class="btn btn-danger btn-sm"
                                href="delete.php?pid=<?php echo urlencode($row["bid"]); ?>"
                                onclick="return confirm('Do you really want to delete this book?');"
                            >
                                Delete
                            </a>
                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</main>

<!-- FOOTER -->

<footer class="text-center mt-5 mb-3">
    <p>Library Management System</p>
</footer>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>

