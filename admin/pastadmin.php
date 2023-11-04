<?php
session_start();
if (!isset($_SESSION["prilogin"])) {
    header('location: prilogin.php');
    exit();
}
if(isset($_SESSION["Pcollege"]))
{
    $college=$_SESSION["Pcollege"];
}
include('db.php');
$sql = "SELECT * FROM transfer_applications WHERE current_college='$college' AND (status != 'PENDING TO SEE' OR status = 'APPROVED BY PRINCIPAL' OR status = 'REJECT BY PRINCIPAL')";
$result = $conn->query($sql);
$j=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
<div class="container-fluide mx-auto p-4">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style = "
border-radius: 15px;">
    <a class="navbar-brand" href="#"><b>Welcome, Principal</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="pastadmin.php">Past Applications</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="../Contactus.php">Contact us</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="../About.html">About us</a>
          </li>
      </ul>
          <div class="mx-2">
            <a href="admindashboard.php">
            <button class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Back</button></a>
        </div>
    </div>
  </nav>
    <div class="container-fluide mx-auto p-4">
    <?php
        if ($result->num_rows > 0) {

        ?>
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
                    <th class="px-4 py-2">Principal Side Status</th>
                    <th class="px-4 py-2">CTE Side Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                                while($row = $result->fetch_assoc()) {
                                    $id=$row["id"];
                                    $fullname=$row["full_name"];
                                    $currentcollege=$row["current_college"];
                                    $admissioncollege=$row["admission_college"];
                                    $sem=$row['semester'];
                                    $dep=$row['department'];
                                    $reason=$row["reason"];
                                    $pdf=$row["pdf_data"];
                                    $status=$row["STATUS"];
                                    $ctestaus=$row["CTESTATUS"];
                                
                ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $j + 1 ?></td>
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
                    <td class="border px-4 py-2"><?php echo $status?></td>
                    <td class="border px-4 py-2"><?php echo $ctestaus?></td>
                </tr>
                <?php
                                }
                ?>
            </tbody>
        </table>
        <?php
            
        }
        else 
        { ?>
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
                    <th class="px-4 py-2">Principal Side Status</th>
                    <th class="px-4 py-2">CTE Side Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                        <td colspan = "10">
                        No Any Application Found
                        </td>
                </tr>
            </tbody>
        </table>
         <?php
        }
        ?>
    </div>
</body>
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