
<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"]==="POST"){

$uname=$_POST["uname"];

$password=$_POST["password"];
$sql=$conn->prepare("select uid, uname,password from users where uname=?");
$sql->bind_param("s",$uname);
$sql->execute();
$sql->bind_result($id,$n,$pass);
$sql->fetch();
if(password_verify($password,$pass)){
    $_SESSION["id"]=$id;
    $_SESSION["uname"]=$n;
   header("Location:home.php");
        exit();
}
 else{
        echo "<script>
        alert('login is not done');
        </script>";
    }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main>
            <h1 class="text-center mt-5 p-4">LOGIN WITH US</h1>
            <div class="container col-5 border rounded shadow mt-5 p-4">
                <form action="" method="POST">
                    
                    <div class="mb-3">
                        <label for="" class="form-label">username</label>
                        <input
                            type="text"
                            class="form-control"
                            name="uname"
                            id=""
                            aria-describedby="helpId"
                            placeholder=""
                        />
                        
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">passowrd</label>
                        <input
                            type="text"
                            class="form-control"
                            name="password"
                            id=""
                            aria-describedby="helpId"
                            placeholder=""
                        />
                        
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Submit
                    </button>
                    
                    
                    
                    
                    








                </form>



            </div>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
