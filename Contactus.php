<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Add Bootstrap CSS link here -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for transition effect */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 60px;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            transition: background-color 0.8s;
        }
        .container:hover{
            background-color:#d3f1ee;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #007BFF;
        }

        textarea {
            height: 150px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #42b9ad;
        }
        .textbox{
            margin-top:20px;
            height:20px;
            width: 400px;
        }
        .para{
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contact Us</h2>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts here, if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php 
        include('db.php');
        if(isset($_POST['submit']))
        {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $desc = $_POST['description'];
            $in_qu = "INSERT into contact_table (name,Email,Description) VALUES ('$name','$email','$desc')";
            $result = mysqli_query($conn,$in_qu);
        if($result)
        {
            echo "<div class= 'container textbox'><p class='para'>Your Query Submitted Successfully</p></div>";
            exit;
        }
        else
        {
            echo ("Not submitted");
            exit;
        }
        }
    ?>
</body>
</html>
