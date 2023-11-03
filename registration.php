<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Page</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins',sans-serif;
}
body{
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
  background: linear-gradient(135deg, #71b7e6, #9b59b6);
}
.container{
  max-width: 700px;
  width: 100%;
  background-color: #fff;
  padding: 25px 30px;
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}
.container .title{
  font-size: 25px;
  font-weight: 500;
  position: relative;
}
.container .title::before{
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  width: 30px;
  border-radius: 5px;
  background: linear-gradient(135deg, #71b7e6, #9b59b6);
}
.content form .user-details{
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 20px 0 12px 0;
}
form .user-details .input-box{
  margin-bottom: 15px;
  width: calc(100% / 2 - 20px);
}
form .input-box span.details{
  display: block;
  font-weight: 500;
  margin-bottom: 5px;
}
.user-details .input-box input{
  height: 45px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 5px;
  padding-left: 15px;
  border: 1px solid #ccc;
  border-bottom-width: 2px;
  transition: all 0.3s ease;
}
.user-details .input-box input:focus,
.user-details .input-box input:valid{
  border-color: #9b59b6;
}
 form .gender-details .gender-title{
  font-size: 20px;
  font-weight: 500;
 }
 form .category{
   display: flex;
   width: 80%;
   margin: 14px 0 ;
   justify-content: space-between;
 }
 form .category label{
   display: flex;
   align-items: center;
   cursor: pointer;
 }
 form .category label .dot{
  height: 18px;
  width: 18px;
  border-radius: 50%;
  margin-right: 10px;
  background: #d9d9d9;
  border: 5px solid transparent;
  transition: all 0.3s ease;
}
 #dot-1:checked ~ .category label .one,
 #dot-2:checked ~ .category label .two,
 #dot-3:checked ~ .category label .three{
   background: #9b59b6;
   border-color: #d9d9d9;
 }
 form input[type="radio"]{
   display: none;
 }
 form .button{
   height: 45px;
   margin: 35px 0
 }
 form .button input{
   height: 100%;
   width: 100%;
   border-radius: 5px;
   border: none;
   color: #fff;
   font-size: 18px;
   font-weight: 500;
   letter-spacing: 1px;
   cursor: pointer;
   transition: all 0.3s ease;
   background: linear-gradient(135deg, #71b7e6, #9b59b6);
 }
 form .button input:hover{
  /* transform: scale(0.99); */
  background: linear-gradient(-135deg, #71b7e6, #9b59b6);
  }
 @media(max-width: 584px){
 .container{
  max-width: 100%;
}
form .user-details .input-box{
    margin-bottom: 15px;
    width: 100%;
  }
  form .category{
    width: 100%;
  }
  .content form .user-details{
    max-height: 300px;
    overflow-y: scroll;
  }
  .user-details::-webkit-scrollbar{
    width: 5px;
  }
  }
  @media(max-width: 459px){
  .container .content .category{
    flex-direction: column;
  }
}
  </style>
</head>
<body>
  <?php
    // db.php contains database connection code, ensure it's correct and included here.
    include 'db.php';
    session_start();

    if (isset($_POST["submit"])) {
      $fname = $_POST["fname"];
      $lname = $_POST["lname"];
      $username = $_POST["username"];
      $mob = $_POST["mob"];
      $email = $_POST["email"];
      $password = $_POST["password"];

      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['username'] = $username;
      $_SESSION['mob'] = $mob;
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $password;
      setcookie("user", $_SESSION['username'], time() + 3400);
      setcookie("password", $_SESSION['password'], time() + 3400);
      $stmt = $conn->prepare("INSERT INTO userdata (fname, lname, username, mob, email, password) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $fname, $lname, $username, $mob, $email, $password);
      if ($stmt->execute()) {
          // Data added successfully!
          echo '<div class="alert alert-success" role="alert">Registration successfull!</div>';
          // Redirect to the login page or any other page you want after successful registration.
          header('Location: index1.php');

          //mail code starts
          $mailSubject = "Succesfully Registered on ITP";
          $mailBody = "
          <hr>
          <h1>
          <tt><b>Welcome to Institute Transfer Portal</b></tt>
          </h1>
          <h2>
              Your Registration is succesfully completed in portal. Now you can apply for institute transfer.
          </h2>
          
          <hr>
          Thanks, 
          Institute Transfer Portal 
          ";

          function mailsender($email, $subject, $body)
          {
            require_once 'PHPMailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
        
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'gpainfo617@gmail.com';                    // SMTP username
            $mail->Password = 'hwhdwqqcwnltztpa';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;
        
        
            $mail->setFrom('gpainfo617@gmail.com', 'Institute Transfer Portal');
            $mail->addReplyTo('gpainfo617@gmail.com');
        
            // Add a recipient
            $mail->addAddress("$email");
        
            $mail->Subject = $subject;
        
        
            $mail->Body = $body;
        
            // Set email format to HTML
            $mail->isHTML(true);


            
            // Send email
            if(!$mail->send()){
              echo "<script type='text/javascript'>alert(\"Failed to send email , but registration is completed\");</script>";
            }
            // else{
            //   echo "<script type='text/javascript'>alert(\"User ID and Password Sent successfully.\");</script>";
            // }

          }

          mailsender($email, $mailSubject, $mailBody);
          header('Location: index1.php');
          exit();
      } else {
          // Data is not added!
          echo '<div class="alert alert-danger" role="alert">Registration Failed!</div>';
          // Redirect back to the registration page to try again.
          header('Location: registration.php');
          exit();
      }
    } else {
      //echo 'Error occures';
    }
  ?>
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form method="POST">
        <div class="user-details">
          <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" placeholder="Enter your name" name="fname" required >
          </div>
          <div class="input-box">
            <span class="details">Last Name</span>
            <input type="text" placeholder="Enter your lastname" name="lname" required>
          </div>
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" placeholder="Enter your username" name="username" required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="text" placeholder="Enter your number" name="mob" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" placeholder="Enter your email" name="email" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" placeholder="Enter your password" name="password" required>
          </div>
        </div>
        <div class="button">
          <input type="submit" value="Register" name="submit">
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
