<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student || Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gray-200">
    <div class="container mx-auto mt-5 hi-80">
        <div class="w-96 bg-white p-6 rounded shadow-lg mx-auto">
            <h2 class="text-2xl font-semibold mb-4">Login</h2>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
                    <input type="text" id="username" name="username"
                        class="mt-1 p-2 w-full border rounded-md @error('username') border-red-500 @enderror" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 p-2 w-full border rounded-md @error('password') border-red-500 @enderror" required>
                </div>
                <button type="submit" name="submit"
                    class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200">
                    Login
                </button>
            </form>
            <br>
            <a href="registration.php" class="block py-2 px-15 text-blue-500 text-center font-semibold">
    Create an account (Student Registration)
</a>
            <?php
    session_start();
    if (isset($_SESSION["login"])) {
        header('location: dashboard.php');
        exit();
    }
    if (isset($_POST["submit"])) {
        include 'db.php';
        $username = $_POST["username"];
        $password = $_POST["password"];
        $ret = mysqli_query($conn, "SELECT * FROM userdata WHERE username='$username' AND password='$password'");
        $row = mysqli_fetch_array($ret);
        if ($row) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email']=$row['email'];
            $_SESSION['name']=$row['fname'];
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header('location: dashboard.php');
            exit();
        } else {
            echo '<script>';
            echo 'alert("Invalid Details!");';
            echo '</script>';
        }
    }
    ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>

