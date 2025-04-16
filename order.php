<html>

<head>
    <title>The Bliss - We Got Your Event</title>
    <link rel="icon" href="Images/WEB logo.png" type="image/gif"> <!-- Icon next to the title -->
    <link rel="stylesheet" type="text/css" href="The Bliss.css">
    <script language="javascript" type="text/javascript" src="The Bliss.js"></script>
</head>

<body bgcolor="#eed4ff">

<?php

$servername = "localhost";
$user = "root";
$pw = "";
$db = "TheBliss";

// Establish connection
$connection = mysqli_connect($servername, $user, $pw, $db);
if (!$connection) {
    die("<center><b>Connection failed:</b> " . mysqli_connect_error() . "</center>");
}

// Ensure form data is set
if (!isset($_POST["fname"], $_POST["lname"], $_POST["address"], $_POST["mail"], $_POST["phone"], $_POST["description"])) {
    die("<center><b>Error:</b> Form data not submitted correctly.</center>");
}

$fname = trim($_POST["fname"]);
$lname = trim($_POST["lname"]);
$add = trim($_POST["address"]);
$mail = trim($_POST["mail"]);
$phone = trim($_POST["phone"]);
$desc = trim($_POST["description"]);

// Validate empty fields
if ($fname == "" || $lname == "" || $add == "" || $mail == "" || $phone == "") {
    echo "<center>
        <div><img src='Images/WEB logo.png' width='250px' height='250px'></div>
        <div style='background-color:black; font-family:Trebuchet MS; font-size:40px; color:#f1f1f1; padding:5px; margin-top:20px; border-radius:30px; width:65%;'>
            You have not entered all required fields<br>Please enter all fields and place the order
        </div>
        <div><input type='button' value='Back' onclick=\"window.location.href='checkout.php';\" style='font-size:35px; margin-top:50px; border-radius:5px;'></div>
    </center>";
    exit();
}

// Validate phone number
if (!is_numeric($phone) || strlen($phone) != 10) {
    echo "<center>
        <div><img src='Images/WEB logo.png' width='250px' height='250px'></div>
        <div style='background-color:black; font-family:Trebuchet MS; font-size:40px; color:#f1f1f1; padding:5px; margin-top:20px; border-radius:30px; width:65%;'>
            Incorrect phone number format<br>Please re-enter and place the order again
        </div>
        <div><input type='button' value='Back' onclick=\"window.location.href='checkout.php';\" style='font-size:35px; margin-top:50px; border-radius:5px;'></div>
    </center>";
    exit();
}

// Check if 'cart' table exists before querying
$checkCartTable = "SHOW TABLES LIKE 'cart'";
$tableResult = mysqli_query($connection, $checkCartTable);
if (mysqli_num_rows($tableResult) == 0) {
    die("<center><b>Error:</b> Table 'cart' does not exist. Please check the database.</center>");
}

// Fetch cart items
$selectqry = "SELECT * FROM cart";
$result = mysqli_query($connection, $selectqry);
if (!$result) {
    die("<center><b>Query Failed:</b> " . mysqli_error($connection) . "</center>");
}

if (mysqli_num_rows($result) > 0) {
    // Fetch max order ID
    $selectmaxOID = "SELECT MAX(orderid) AS maxoid FROM orderproducts";
    $maxoidresult = mysqli_query($connection, $selectmaxOID);
    $oid = 1;

    if ($maxoidresult && mysqli_num_rows($maxoidresult) > 0) {
        $oidrow = mysqli_fetch_assoc($maxoidresult);
        $oid = $oidrow['maxoid'] + 1;
    }

    // Insert order details
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row["productid"];
        $qty = $row["qty"];

        $insertquery = "INSERT INTO orderproducts (orderid, fname, lname, address, email, phone, description, productid, qty) 
                        VALUES ('$oid', '$fname', '$lname', '$add', '$mail', '$phone', '$desc', '$pid', '$qty')";
        $insertresult = mysqli_query($connection, $insertquery);

        if (!$insertresult) {
            die("<center><b>Insert Failed:</b> " . mysqli_error($connection) . "</center>");
        }
    }

    // Empty cart after successful order placement
    $emptycart = "DELETE FROM cart";
    $deleteresult = mysqli_query($connection, $emptycart);

    echo "<center>
            <div><img src='Images/WEB logo.png' width='250px' height='250px'></div>
            <div style='background-color:black; font-family:Trebuchet MS; font-size:40px; color:#f1f1f1; padding:5px; margin-top:20px; border-radius:30px; width:65%;'>
                Order placed successfully!<br>Your order will be delivered within 3-4 days :)
            </div>
            <div><input type='button' value='Continue Shopping' onclick='Home()' style='font-size:35px; margin-top:50px; border-radius:5px;'></div>
        </center>";
} else {
    echo "<center><b>Your cart is empty. Please add products before placing an order.</b></center>";
}

mysqli_close($connection);

?>

</body>
</html>
