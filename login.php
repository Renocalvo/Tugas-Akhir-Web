<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login Page</title>

    <script>
        function showSnackbar(messages, type) {
            var snackbar = document.getElementById("snackbar");

            function displayMessage(index) {
                if (index >= messages.length) return;

                snackbar.textContent = messages[index];
                snackbar.classList.remove("snackbar-error", "snackbar-success");

                if (type === "error") {
                    snackbar.classList.add("snackbar-error");
                } else if (type === "success") {
                    snackbar.classList.add("snackbar-success");
                }

                snackbar.classList.add("show");

                setTimeout(function() {
                    snackbar.classList.remove("show");
                    setTimeout(function() {
                        displayMessage(index + 1);
                    }, 500);
                }, 3000);
            }

            displayMessage(0);
        }
    </script>
</head>

<body style="background:url(assets/background.png); background-size: cover;">
    <div id="snackbar" class="snackbar">This is a snackbar alert!</div>

    <div class="jumbotron" style="background-color: transparent; margin-bottom: 0;">
        <div class="container-fluid p-5" style="background-color: rgba(0, 0, 0, 0.425); max-width: 80vh; padding: 2vh;">
            <div class="container">
                <h3 class="text-center mt-md-2" style="color: #fff;"><b>LOGIN</b></h3>
                <h5 class="text-center mb-md-5" style="color: #fff;">Silahkan Masuk Untuk melanjutkan</h5>

                <?php
                session_start();
                if (isset($_POST["login"])) {
                    $email = $_POST["email"];
                    $password = $_POST["password"];

                    require_once "./inc/inc_connection.php";

                    $sql = "SELECT * from users where email = '$email'";
                    $result = mysqli_query($koneksi, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    if ($user) {
                        if (password_verify($password, $user["password"])) {
                            // Simpan data user di session setelah berhasil login
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['full_name'] = $user['full_name'];
                            $_SESSION['role'] = $user['role'];

                            // Redirect berdasarkan role
                            if ($user['role'] === 'Admin') {
                                header("Location: index-users.php");
                            } elseif ($user['role'] === 'User') {
                                header("Location: landingpage.php");
                            } else {
                                echo "<script>showSnackbar(['Role not recognized!'], 'error');</script>";
                            }
                            exit();
                        } else {
                            echo "<script>showSnackbar(['Incorrect password!'], 'error');</script>";
                        }
                    } else {
                        echo "<script>showSnackbar(['Email not found!'], 'error');</script>";
                    }
                }
                ?>

                <form method="post" action="login.php">
                    <div class="form-group mt-5">
                        <input type="email" name="email" class="form-control" style="color: #fff; background-color: transparent; border: 1px solid #fff;" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                        <label for="exampleInputEmail1" class="label-form">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" style="color: #fff; background-color: transparent; border: 1px solid #fff;" id="exampleInputPassword1" placeholder="">
                        <label for="exampleInputPassword1" class="label-form">Password</label>
                    </div>
                    <button type="submit" name="login" class="btn btn-block mt-5 mb-2" style="background-color: #ffdb15;"><b>LOGIN</b></button>
                </form>

                <a href="#" style="text-decoration: none; color: #ffdb15;">Lupa Password?</a>
                <h6 class="text-center mt-5" style="color: #fff;">Belum Punya Akun? <a href="register.php" style="color: #ffdb15;">Sign Up</a></h6>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>