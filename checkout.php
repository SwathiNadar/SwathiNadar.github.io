

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "TheBliss";

// Database connection
$connection = mysqli_connect($servername, $username, $password, $database);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch cart items
$selectqry = "SELECT * FROM cart";
$result = mysqli_query($connection, $selectqry);

if (!$result) {
    die("Query Failed: " . mysqli_error($connection)); // Debugging SQL errors
}

// Check if the cart is empty
if (mysqli_num_rows($result) == 0) {
    echo "<center>
            <div>
                <img src='Images/WEB logo.png' width='250px' height='250px'>
            </div>
            <div style='background-color:black; 
                font-family:Trebuchet MS; 
                font-size:40px;
                color:#f1f1f1;
                padding:5px;
                margin-top:20px;
                border-radius:30px;
                width:65%;'>
                Your cart is empty!
            </div>
        </center>";
    ?>
    <center>
        <div>
            <input type="button" value="Continue Shopping" id="submitButton" class="bothButtons" onclick="Home()" style="font-size:35px; margin-top:50px; border-radius:5px;">
        </div>
    </center>
    <?php
} else {
?>
    <table width="100%">
        <tr>
            <td><img src="Images/WEB logo.png" width="130px" height="130px" style="padding:10px;"></td>
            <td width="80%">
                <font style="margin-left:280px; background-color:black; color:white; border-radius:40px; padding:15px; font-family:Trebuchet MS; font-size:30px; font-weight:bold;">
                    Enter shipping details!
                </font>
            </td>
        </tr>
    </table>

    <center>
        <div>
            <form name="checkout" method="POST" action="http://localhost/TheBliss/order.php">
                <table>
                    <tr>
                        <td width="280px" id="labels">First Name</td>
                        <td><input type="text" name="fname" placeholder="Enter First Name" id="textboxes" required></td>
                    </tr>
                    <tr>
                        <td id="labels">Last Name</td>
                        <td><input type="text" name="lname" placeholder="Enter Last Name" id="textboxes" required></td>
                    </tr>
                    <tr>
                        <td id="labels">Address</td>
                        <td><input type="text" name="address" placeholder="Enter Address" id="textboxes" required></td>
                    </tr>
                    <tr>
                        <td id="labels">E-mail</td>
                        <td><input type="email" name="mail" placeholder="Enter E-mail" id="textboxes" required></td>
                    </tr>
                    <tr>
                        <td id="labels">Phone</td>
                        <td><input type="text" name="phone" placeholder="Enter Phone" id="textboxes" required pattern="[0-9]{10}"></td>
                    </tr>
                    <tr>
                        <td id="labels">Description</td>
                        <td><textarea name="description" rows="5" placeholder="Description if any (e.g., number candles for age 12)" id="textboxes"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan=2 align="center">
                            <input type="submit" name="submit" value="Place Order" id="submitButton" class="bothButtons">
                            <input type="reset" name="cancel" value="Cancel" id="cancelButton" class="bothButtons">
                        </td>
                    </tr>
                </table>
            </form>

            <table>
                <tr>
                    <?php	
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <td style="padding:10px;">
                            <img src="<?php echo htmlspecialchars($row["pimage"]); ?>" width="180px" height="180px">
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
    </center>
<?php
}
mysqli_close($connection);
?>

