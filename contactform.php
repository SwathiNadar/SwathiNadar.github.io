<?php 
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "TheBliss";

$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("<center>
            <div style='background-color:black; font-family:trebuchet ms; font-size:25px; color:#f1f1f1;
            padding:10px; margin-top:20px; border-radius:15px; width:60%;'>
            Database Connection Failed: " . $connection->connect_error . "</div>
        </center>");
}

// ✅ Only process the form if it's submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields exist
    $fname = isset($_POST["fname"]) ? trim($_POST["fname"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $subject = isset($_POST["subject"]) ? trim($_POST["subject"]) : "";
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : "";

    // Validate empty fields
    if (empty($fname) || empty($email) || empty($subject) || empty($message)) {
        echo "<center>
                <div>
                    <img src='Images/WEB logo.png' width='250px' height='250px'>
                </div>
                <div style='background-color:black; font-family:trebuchet ms; font-size:30px;
                color:#f1f1f1; padding:10px; margin-top:20px; border-radius:15px; width:60%;'>
                    Please fill all required fields and try again.
                </div>
                <div>
                    <input type='button' value='Back to Contact' id='submitButton' class='bothButtons'
                    onclick='Contact()' style='font-size:25px; margin-top:30px; border-radius:5px;'>
                </div>
            </center>";
    } else {
        // Secure data (prevent SQL Injection)
        $fname = $connection->real_escape_string($fname);
        $email = $connection->real_escape_string($email);
        $subject = $connection->real_escape_string($subject);
        $message = $connection->real_escape_string($message);

        // Insert query
        $sql = "INSERT INTO contactform (name, email, subject, message) VALUES ('$fname', '$email', '$subject', '$message')";

        if ($connection->query($sql) === TRUE) {
            echo "<center>
                    <div>
                        <img src='Images/WEB logo.png' width='250px' height='250px'>
                    </div>
                    <div style='background-color:black; font-family:trebuchet ms; font-size:30px;
                    color:#f1f1f1; padding:10px; margin-top:20px; border-radius:15px; width:60%;'>
                        Your message has been sent successfully!
                    </div>
                    <div>
                        <input type='button' value='Back to Home' id='submitButton' class='bothButtons'
                        onclick='Home()' style='font-size:25px; margin-top:30px; border-radius:5px;'>
                    </div>
                </center>";
        } else {
            echo "<center>
                    <div>
                        <img src='Images/WEB logo.png' width='250px' height='250px'>
                    </div>
                    <div style='background-color:black; font-family:trebuchet ms; font-size:30px;
                    color:#f1f1f1; padding:10px; margin-top:20px; border-radius:15px; width:60%;'>
                        Your message could not be sent. Please try again.
                    </div>
                    <div>
                        <input type='button' value='Back to Contact' id='submitButton' class='bothButtons'
                        onclick='Contact()' style='font-size:25px; margin-top:30px; border-radius:5px;'>
                    </div>
                </center>";
        }
    }
} else {
    echo "<center>
            <div style='background-color:black; font-family:trebuchet ms; font-size:30px;
            color:#f1f1f1; padding:10px; margin-top:20px; border-radius:15px; width:60%;'>
                Invalid form submission.
            </div>
        </center>";
}

// Close database connection
$connection->close();
?>

