<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Responsive Footer</title>
    <style>/* styles.css */
        body {
            margin: 0;
            padding: 0;
        }
        
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
        }
        
        .footer-link {
            text-decoration: none;
            color: #fff;
            margin: 0 20px;
        }
        
        @media (max-width: 768px) {
            .footer-links {
                flex-direction: column;
            }
        
            .footer-link {
                margin: 10px 0;
            }
        }
        </style>
</head>
<body>
    <footer>
        <div class="footer-links">
            <a href="About.html" class="footer-link">About it</a>
            <a href="Contactus.php" class="footer-link">Contact us</a>
        </div>
    </footer>
</body>
</html>
