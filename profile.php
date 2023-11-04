<?php
session_start();
if(!isset($_SESSION['login']))
{
    header('Location: index1.php');
    exit();
}
if(isset($_SESSION['user_id'] ))
{
    $userid=$_SESSION['user_id'];
}
$j=0;
    include('db.php');
    $sql="SELECT * FROM transfer_applications WHERE id='$userid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
       
    } else {
        //echo "No results found.";
    }

    $GetUserSQL = "select (fname) from userdata where id = $userid";
    $GotUser = $conn->query($GetUserSQL);
    $User = mysqli_fetch_array($GotUser);
    // $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student || Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <script>
        let pdfWindow = null;
        function togglePdf(pdfData) {
            if (pdfWindow && !pdfWindow.closed) {
                pdfWindow.close();
                pdfWindow = null;
            } else {
                pdfWindow = window.open('', '_blank');
                pdfWindow.document.write('<embed width="100%" height="100%" src="data:application/pdf;base64,' + pdfData + '" />');
                pdfWindow.document.close();
            }
        }
    </script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body class="bg-gray-100">



    <div class="container-fluide mx-auto p-4">

<!-- navbar start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style = "
border-radius: 15px;">
    <a class="navbar-brand" href="dashboard.php"><b>Welcome, <?php echo $User['fname']; ?></b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="form.php">File Application</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="profile.php">Your Profile</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="Contactus.php">Contact us</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="About.html">About us</a>
          </li>
      </ul>
          <div class="mx-2">
            <a href="dashboard.php">
            <button class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Back</button></a>
        </div>
    </div>
  </nav>


  <!-- navbar end -->

<br>
</div>

<div class="container">
<?php
            $sql1 = "SELECT * from userdata where id='$userid'";
            $result = mysqli_query($conn,$sql1);
            if ($result->num_rows > 0) {
                // Fetch user data
                $row = $result->fetch_assoc();
                $firstName = $row["fname"];
                $lastName = $row["lname"];
                $username = $row["username"];
                $phoneNumber = $row["mob"];
                $email = $row["email"];
                $password = $row["password"];
            }
        ?>
       <form action="" method="POST">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name:</label>
                <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $firstName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name:</label>
                <input type="text" id="lastName" name="lastName" class="form-control" value="<?php echo $lastName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" value="<?php echo $phoneNumber; ?>"required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                 <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>"required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>" required>
            </div>
            <input type="submit" value="Update" class="btn btn-primary" name="Update">
        </form>
            <?php
                if(isset($_POST['Update']))
                {
                    $updatedFirstName = $_POST['firstName'];
                    $updatedLastName = $_POST['lastName'];
                    $updatedUsername = $_POST['username'];
                    $updatedPhoneNumber = $_POST['phoneNumber'];
                    $updatedEmail = $_POST['email'];
                    $updatedPassword = $_POST['password'];
                    $sql2 = "UPDATE userdata SET fname = '$updatedFirstName', lname = '$updatedLastName', username = '$updatedUsername', mob = '$updatedPhoneNumber', email = '$updatedEmail', password = '$updatedPassword' WHERE id = '$userid'";
                    $result11 = mysqli_query($conn,$sql2); 
                    if($result11)
                    {
                        echo "<script>window.location.replace('dashboard.php')</script>";
                    }
                }
            ?>


          </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
</html>