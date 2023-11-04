<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>

<body class="bg-gray-200">
    <div class="container mx-auto mt-5">
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
            <?php
            
    session_start();
    if (isset($_SESSION["prilogin"])) {
        header('location: admindashboard.php');
        exit();
    }
    if (isset($_POST["submit"])) {
        include 'db.php';
        $username = $_POST["username"];
        $password = $_POST["password"];
        $ret = mysqli_query($conn, "SELECT * FROM priuserdata WHERE username='$username' AND password='$password'");
        $row = mysqli_fetch_array($ret);
        if ($row) {
            $_SESSION['prilogin'] = true;
            $_SESSION['Puser_id'] = $row['id'];
            $_SESSION['Pcollege'] = $row['college_name'];
            header('location: admindashboard.php');
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

