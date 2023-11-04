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
    <link href="output.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playpen+Sans:wght@300&display=swap');

        * {
            margin: 0px;
            padding: 0px;
        }

        .m {
            box-shadow: rgba(136, 165, 191, 0.48) 6px 2px 16px 0px, rgba(255, 255, 255, 0.8) -6px -2px 16px 0px;
        }

        .head {
            font-family: 'Playpen Sans', cursive;
        }

        .h-140 {
            height: 140vh;
        }
        .h-160 {
            height: 160vh;
        }
    </style>
</head>

<body>
<div class="flex justify-between mb-4">

        </div>
    <div class="h-140 px w-auto flex justify-center items-center overflow-x-hidden" id="hight">
        <div class="m h-fit w-3/5 p-6 pb-4 border-2 border-solid">
            <form id="transferForm" method="POST" enctype="multipart/form-data">
                <h1 class="head text-center text-3xl">College Transfer Application Form</h1>
                <div class="w-full h-full grid pt-10 gap-8">
                    <div class="w-full flex justify-center">
                        <div class="w-11/12 relative">
                            <input type="text" id="fullName" name="fullName" required
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer "
                                placeholder=" " />
                            <label for="fullName"
                                class="absolute text-sm bg-white text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:bg-white peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Full
                                Name</label>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-11/12">
                            <label for="currentCollege"
                                class="block text-sm font-medium leading-6 text-gray-900">Current College</label>
                            <div class="mt-2">
                                <select id="currentCollege" name="currentCollege" autocomplete="country-name" required
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected disabled hidden>Select College</option>
                                    <option value="College A">College A</option>
                                    <option value="College B">College B</option>
                                    <option value="College C">College C</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-11/12">
                            <label for="admissionCollege"
                                class="block text-sm font-medium leading-6 text-gray-900">Admission College</label>
                            <div class="mt-2">
                                <select id="admissionCollege" name="admissionCollege" autocomplete="country-name"
                                    required
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected disabled hidden>Select College</option>
                                    <option value="College X">College X</option>
                                    <option value="College Y">College Y</option>
                                    <option value="College Z">College Z</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-11/12">
                            <label for="admissionCollege"
                                class="block text-sm font-medium leading-6 text-gray-900">Semester</label>
                            <div class="mt-2">
                                <select id="admissionCollege" name="semester" autocomplete="country-name"
                                    required
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected disabled hidden>Select Semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-11/12">
                            <label for="admissionCollege"
                                class="block text-sm font-medium leading-6 text-gray-900">Department</label>
                            <div class="mt-2">
                                <select id="admissionCollege" name="department" autocomplete="country-name"
                                    required
                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected disabled hidden>Select Department</option>
                                    <option value="Computer Science and Engineering">Computer Science and Engineering</option>
                                    <option value="Electrical Engineering">Electrical Engineering</option>
                                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                                    <option value="Civil Engineering">Civil Engineering</option>
                                    <option value="Chemical Engineering">Chemical Engineering</option>
                                    <option value="Aerospace Engineering">Aerospace Engineering</option>
                                    <option value="Bioengineering">Bioengineering</option>
                                    <option value="Environmental Engineering">Environmental Engineering</option>
                                    <option value="Materials Engineering">Materials Engineering</option>
                                    <option value="Industrial Engineering">Industrial Engineering</option>
                                    <option value="Petroleum Engineering">Petroleum Engineering</option>
                                    <option value="Nuclear Engineering">Nuclear Engineering</option>
                                    <option value="Systems Engineering">Systems Engineering</option>
                                    <option value="Agricultural Engineering">Agricultural Engineering</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-11/12 relative">
                            <textarea id="reason" name="reason" rows="4" cols="10"
                                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder="" required></textarea>
                            <label for="reason"
                                class="absolute text-base bg-white text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] dark:bg-gray-900 px-2 peer-focus:bg-white peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-6 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Reason
                                for Transfer</label>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <div class="w-11/12">
                            <label for="nocLetter" class="block text-sm font-medium leading-6 text-gray-900">Upload your
                                NOC(Non Objection Certificate) in PDF</label>
                            <div class="flex items-center justify-center w-full mt-2">
                                <label for="nocLetter" id="nocLable"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center  justify-center pt-5 pb-6">
                                        <div>
                                            <img src="file-pdf-regular.svg" alt="pdf" height="50" width="50"
                                                class="block">
                                        </div>
                                    </div>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">NOC in Pdf</p>
                                    <p id="file-name"></p>
                                    <input id="nocLetter" name="nocLetter" type="file" class="hidden" accept=".pdf"
                                        required />
                                </label>
                            </div>
                            <div class="flex hidden mt-2 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                role="alert" id="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 mr-3 mt-[2px]" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Danger</span>
                                <div>
                                    <span class="font-medium">Ensure that these requirements are met:</span>
                                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                                        <li>File type is must be PDF</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-center">
                        <input type="submit" name="submit" value="submit" id="submit"
                            class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="form.js"></script>
</body>

</html>