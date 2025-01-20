
<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "password"; // Replace with your database password
$dbname = "dictionary";

// Create a database connection .....
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a word is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['word'])) {
    $word = $conn->real_escape_string($_POST['word']); // Prevent SQL injection
    $sql = "SELECT meaning FROM words WHERE word='$word'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary Result</title>
    <style>
        :root {
            --primary: #1a237e; /* Dark blue */
            --secondary: #536dfe; /* Light blue */
            --accent: #ffeb3b; /* Yellow */
            --white: #cce6f3;
            --gray-light: #e1f0f8; /* Updated to match background */
            --gray-dark: #616161;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-light); /* Updated background color */
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--gray-dark);
        }

        .dictionary-logo {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        .logo-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .result-box {
            background: var(--white); /* White background for the result box */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px 50px;
            width: 60%;
            max-width: 600px;
            text-align: center;
        }

        .result-box h2 {
            color: var(--primary);
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .result-box p {
            font-size: 1.25rem;
            color: var(--gray-dark);
            margin: 20px 0;
        }

        .back-btn {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 50px;
            transition: background-color 0.3s ease;
            margin-top: 30px; /* Adds space between the result box and the button */
        }

        .back-btn:hover {
            background-color: var(--secondary);
        }

        .back-btn:focus {
            outline: none;
        }
        
        .no-result {
            font-size: 1.2rem;
            color: var(--accent);
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Dictionary Logo -->
    <div class="dictionary-logo">
        <img src="images/research.png" alt="Logo" class="logo-image">
        Dictionary
    </div>

    <!-- Result Box -->
    <div class="result-box">
        <?php
        if (isset($result)) {
            if ($result->num_rows > 0) {
                // Display the meaning
                while ($row = $result->fetch_assoc()) {
                    echo "<h2>Meaning:</h2>";
                    echo "<p>" . htmlspecialchars($row['meaning']) . "</p>";
                }
            } else {
                echo "<p class='no-result'>Word not found in the dictionary.</p>";
            }
        } else {
            echo "<p class='no-result'>No word provided.</p>";
        }
        ?>
    </div>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='index.html'">Back</button>

</body>
</html>

<?php
$conn->close();
?>
