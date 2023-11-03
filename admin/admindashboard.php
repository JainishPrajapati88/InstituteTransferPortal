<?php
session_start();
if (!isset($_SESSION["prilogin"])) {
    header('location: prilogin.php');
    exit();
}

include('db.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
<div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Welcome Principal</h1>
            <div class="space-x-2">
                <a href="../LogOut.php" class="btn btn-danger">LogOut</a>
            </div>
    </div>


        <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2">SR.No</th>
                    <th class="px-4 py-2">FULL NAME</th>
                    <th class="px-4 py-2">CURRENT COLLEGE</th>
                    <th class="px-4 py-2">ADMISSION COLLEGE</th>
                    <th class="px-4 py-2">SEMESTER</th>
                    <th class="px-4 py-2">DEPARTMENT</th>
                    <th class="px-4 py-2">REASON</th>
                    <th class="px-4 py-2">PDF</th>
                    <th class="px-4 py-2">Approval</th>
                    <th class="px-4 py-2">Rejection</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql="SELECT * FROM transfer_applications WHERE status != 'APPROVED BY PRINCIPAL' AND status != 'REJECT BY PRINCIPAL'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0)
                    {
                        $j=1; 
                            while($row = $result->fetch_assoc())
                            {
                                $id=$row["id"];
                                $fullname=$row["full_name"];
                                $currentcollege=$row["current_college"];
                                $admissioncollege=$row["admission_college"];
                                $sem=$row['semester'];
                                $dep=$row['department'];
                                $reason=$row["reason"];
                                $pdf=$row["pdf_data"];   
                                             
                ?>
                
                <tr>
                    <td class="border px-4 py-2"><?php echo $j ?></td>
                    <td class="border px-4 py-2"><?php echo $fullname ?></td>
                    <td class="border px-4 py-2"><?php echo $currentcollege ?></td>
                    <td class="border px-4 py-2"><?php echo $admissioncollege ?></td>
                    <td class="border px-4 py-2"><?php echo $sem ?></td>
                    <td class="border px-4 py-2"><?php echo $dep ?></td>
                    <td class="border px-4 py-2"><?php echo $reason ?></td>
                    <td class="border px-4 py-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            onclick="togglePdf('<?php echo base64_encode($pdf); ?>')">View PDF</button>
                    </td>
                    <td class="border px-4 py-2">
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id?>">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" name="approve">Approve</button>
                        </form>
                    </td>
                    <td class="border px-4 py-2">
                        <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" name="reject">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php
                    $j = $j + 1;
                        }
                        }else{
                            echo " <td colspan = '10'>
                            No Any Application Found
                            </td>";
                        }
                ?>
            </tbody>
        </table>
    </div>

    
   
                       

</body>
<?php
if(isset($_POST["approve"]))
{
    $status="APPROVED BY PRINCIPAL";
    $id=$_POST["id"];
    $sql="UPDATE transfer_applications SET STATUS='$status' where id='$id'";
    $result = $conn->query($sql);
    if($result)
    {
        echo "<script>alert('approved')</script>";
        echo"<script>window.location.replace('admindashboard.php')</script>";
    }
}
if(isset($_POST["reject"]))
{
    $status="REJECT BY PRINCIPAL";
    $id=$_POST["id"];
    $sql="UPDATE transfer_applications SET STATUS='$status' where id='$id'";
    $result = $conn->query($sql);



    if($result)
    {
        echo "<script>alert('Rejected')</script>";

        $GetUSR = "Select (email) from userdata where id = $id";
        $res = $conn->query($GetUSR);
    
        $fetchMail = mysqli_fetch_array($res);
         
        $emailA = $fetchMail['email'];

        //mail code starts
        $mailSubject = "Rejected for institute transfer";
        $mailBody = "
        <hr>
        <h1>
        <tt><b>Welcome to Institute Transfer Portal</b></tt>
        </h1>
        <h2>
            Sorry to say but you are rejected by principal for your institute transfer.
        </h2>
        
        <hr>
        Thanks, 
        Institute Transfer Portal 
        ";

        function mailsender($email, $subject, $body)
        {
          require_once '../PHPMailer/PHPMailerAutoload.php';

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
            // echo "<script type='text/javascript'>alert(\"Failed to send email , but registration is completed\");</script>";
          }
          // else{
          //   echo "<script type='text/javascript'>alert(\"User ID and Password Sent successfully.\");</script>";
          // }

        }

        mailsender($emailA, $mailSubject, $mailBody);





        echo"<script>window.location.replace('admindashboard.php')</script>";
    }
}
$conn->close();
?>
</html>



