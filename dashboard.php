<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h1><a href="form.php" class="btn btn-danger">Form</a></h1>
    <div class="container mx-auto p-4">
        <?php
        session_start();
        if(!isset($_SESSION['login']))
        {
            header('Location: index.php');
            exit();
        }
        if(isset($_SESSION['user_id'] ))
        {
            $userid=$_SESSION['user_id'];
        }
        include('db.php');
        $sql="SELECT * FROM transfer_applications WHERE id='$userid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $j = 0;
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
                $id = $row["id"];
                $fullname = $row["full_name"];
                $currentcollege = $row["current_college"];
                $admissioncollege = $row["admission_college"];
                $sem = $row['semester'];
                $dep = $row['department'];
                $reason = $row["reason"];
                $pdf = $row["pdf_data"];
                $status = $row["STATUS"];
                $ctestaus = $row["CTESTATUS"];
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
                $j++;
            }
            ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "No data found";
        }
        $conn->close();
        ?>
    </div>
    </div>
</body>
</html>
