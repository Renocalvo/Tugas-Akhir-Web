<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Sign Up Page</title>

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

<body style="background: url(assets/background.png); background-size: cover;">

    <div id="snackbar" class="snackbar">This is a snackbar alert!</div>

    <div class="jumbotron" style="background-color: transparent; margin-bottom: 0;">
        <div class="container-fluid p-4" style="background-color: rgba(0, 0, 0, 0.425); max-width: 80vh; padding: 2vh;">
            <div class="container">
                <h3 class="text-center" style="color: white;"><b>SIGN UP</b></h3>
                <h5 class="text-center" style="padding-bottom: 10vh; color: #fff;">Silahkan masuk untuk melanjutkan</h5>

                <?php
                if (isset($_POST["submit"])) {
                    $fullname = $_POST["fullname"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $confirmPassword = $_POST["confirm_password"];

                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $errors = array();

                    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
                        array_push($errors, "All fields are required");
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, "Email is not valid");
                    }
                    if (strlen($password) < 8) {
                        array_push($errors, "Password must be at least 8 characters");
                    }
                    if ($password !== $confirmPassword) {
                        array_push($errors, "Password does not match");
                    }

                    require_once "./inc/inc_connection.php";
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($koneksi, $sql);
                    $rowCount = mysqli_num_rows($result);
                    if ($rowCount > 0) {
                        array_push($errors, "Email already exists");
                    }

                    if (count($errors) > 0) {
                        $jsErrors = json_encode($errors);
                        echo "<script>showSnackbar($jsErrors, 'error');</script>";
                    } else {
                        // Default role is 'user', we don't need to set it manually here
                        $role = 'User';

                        // Insert user data into the database with the role 'user'
                        $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)";
                        $stmt = mysqli_stmt_init($koneksi);

                        if (mysqli_stmt_prepare($stmt, $sql)) {
                            mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $passwordHash, $role);
                            mysqli_stmt_execute($stmt);
                            echo "<script>
            showSnackbar(['You are registered successfully.'], 'success');
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 3000); // Delay of 3 seconds
            </script>";
                        } else {
                            die("Something went wrong");
                        }
                    }
                }
                ?>


                <form action="register.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname"
                            style="color: #fff; background-color: transparent; border: 1px solid #fff;"
                            id="namapengguna" placeholder="">
                        <label for="namapengguna" class="label-form">Nama Lengkap</label>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email"
                            style="color: #fff; background-color: transparent; border: 1px solid #fff;" id="Email1"
                            aria-describedby="emailHelp" placeholder="">
                        <label for="Email1" class="label-form">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"
                            style="color: #fff; background-color: transparent; border: 1px solid #fff;" id="Password1"
                            placeholder="">
                        <label for="Password1" class="label-form">Password</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password"
                            style="color: #fff; background-color: transparent; border: 1px solid #fff;"
                            id="confirm-pass" placeholder="">
                        <label for="confirm-pass" class="label-form">Confirm Password</label>
                    </div>

                    <button type="submit" value="Register" name="submit" class="btn btn-warning btn-lg btn-block"
                        style="margin-bottom: 4vh;"><b>REGISTER</b></button>
                    <h6 class="text-center mt-3" style="color: #fff;">Sudah Punya Akun? <a href="login.php"
                            style="color: #ffdb15;">Login</a></h6>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <style>
        @media screen and (max-width: 370px) {
            .form-check p {
                display: none;
            }
        }
    </style>

</body>

</html>