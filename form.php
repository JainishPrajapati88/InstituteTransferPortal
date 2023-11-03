<?php
session_start();
if(!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
if(isset($_SESSION['user_id'] ))
{
    $userid=$_SESSION['user_id'];
}
include('db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $currentCollege = $_POST['currentCollege'];
    $admissionCollege = $_POST['admissionCollege'];
    $reason = $_POST['reason'];
    $semester=$_POST['semester'];
    $department=$_POST['department'];
    $pdfFileSize = $_FILES['nocLetter']['size'];
    $maxFileSize = 1000 * 1024;
    if ($pdfFileSize > $maxFileSize) {
        echo '<script>alert("The uploaded PDF file size exceeds the limit of 700 KB.");</script>';
    } else {
        $pdfTempName = $_FILES['nocLetter']['tmp_name'];
        $pdfContent = addslashes(file_get_contents($pdfTempName));
        $sql = "INSERT INTO transfer_applications (id,full_name, current_college, admission_college, reason, pdf_data,department,semester,STATUS,CTESTATUS) VALUES ($userid,'$fullName', '$currentCollege', '$admissionCollege', '$reason', '$pdfContent','$department','$semester','PENDING TO SEE','PENDING TO SEE')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Succesfully Submited.");</script>';

            $sql = "Select (email) from userdata where id = $userid";
            $res = $conn->query($sql);

            $fetchMail = mysqli_fetch_array($res);
             
            $emailA = $fetchMail['email'];
            
             //mail code starts
            $mailSubject = "Application on ITP";
            $mailBody = "
            <hr>
            <h1>
            <tt><b>Welcome to Institute Transfer Portal</b></tt>
            </h1>
            <h2>
                You have filled application to transfer the institute.
            </h2>

            <br>

            <h3>Details you have filled for application</h3>

            <h1>Name : $fullName</h1><br>
            <h1>Current College : $currentCollege</h1><br>
            <h1>In which college you want to go : $admissionCollege</h1><br>
            <h1>Reason : $reason</h1><br>
            <h1>Semester : $semester</h1><br>
            <h1>Department : $department</h1><br>
            
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
                echo "<script type='text/javascript'>alert(\"The Details you have filled , also mailed on your registetred mail ID\");</script>";
                }
                // else{
                //   echo "<script type='text/javascript'>alert(\"User ID and Password Sent successfully.\");</script>";
                // }

            }


            mailsender($emailA, $mailSubject, $mailBody);

              header('Location: index1.php');
          
        } else {
            echo '<script>alert("Errow while uploaing.");</script>';
            echo "<script>window.location.replace('form.php')</script>";
        }
    }
    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Transfer Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Ubuntu&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Ubuntu';
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .btn-dashboard {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .form-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin: 10px 0;
        }

        label {
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-submit {
            background: linear-gradient(to bottom right, #673AB7, #2196F3);
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: linear-gradient(to bottom right, #5E35B1, #1976D2);
        }

        html {
  scroll-behavior: smooth;
}
    </style>
</head>

<body>
    <br>
    <a href="dashboard.php" class="btn-dashboard btn btn-danger">Go to Dashboard</a>
    <div class="container">
        <div class="form-container">
            <form id="transferForm" method="POST" enctype="multipart/form-data">
                <h1 class="text-center text-3xl">College Transfer Application Form</h1>
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" required placeholder="Your Full Name" />
                </div>
                <div class="form-group">
                    <label for="currentCollege">Current College</label>
                    <select id="currentCollege" name="currentCollege" required>
                        <option value="" selected disabled hidden>Select College</option>
                        <option value="College A">College A</option>
                        <option value="College B">College B</option>
                        <option value="College C">College C</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="admissionCollege">Admission College</label>
                    <select id="admissionCollege" name="admissionCollege" required>
                        <option value="" selected disabled hidden>Select College</option>
                        <option value="College X">College X</option>
                        <option value="College Y">College Y</option>
                        <option value="College Z">College Z</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" required>
                        <option value="" selected disabled hidden>Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <select id="department" name="department" required>
                        <option value="" selected disabled hidden>Select Department</option>
                        <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                        <!-- Add more options here -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="reason">Reason for Transfer</label>
                    <textarea id="reason" name="reason" rows="4" cols="10" required placeholder="Enter your reason for transfer"></textarea>
                </div>
                <div class="form-group">
                    <label for="nocLetter">Upload your NOC(Non Objection Certificate) in PDF</label>
                    <input type="file" id="nocLetter" name="nocLetter" accept=".pdf" required />
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Submit" class="btn-submit">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
