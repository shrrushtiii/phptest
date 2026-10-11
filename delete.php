<?php
include "db.php";

$uid = $_SESSION["uid"];

if (isset($_GET["bid"])) {

    $pid = $_GET["bid"];

    $sql = $conn->prepare(
        "DELETE FROM products WHERE bid=? AND uid=?"
    );

    $sql->bind_param("ii", $bid, $uid);

    if ($sql->execute()) {
        echo "<script>
                alert('Product Deleted Successfully');
                window.location.href='home.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Product Not Deleted');
                window.location.href='home.php';
              </script>";
    }
}
?>