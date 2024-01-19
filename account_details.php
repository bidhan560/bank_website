<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details - Bank of Shrestha</title>
    <link rel="stylesheet" href="account_details_styles.css">
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "CSD223_bidhan";

    // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }

        $balance=0;

        $sql = "SELECT balance FROM accounts ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $balance=$row['balance'];
        }
        } else {
             $balance=0;
        }

        //echo $balance;





        if(isset($_POST['withdraw']))
        {

            $balance=$balance-$_POST['amount'];

           // $sql = "INSERT INTO accounts ( withdraw, balance) VALUES ('".$_POST['amount']."','".$balance."')";

           $sql="INSERT INTO `accounts`( `withdraw`, `balance`) VALUES ('".$_POST['amount']."','".$balance."')";

            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            
        }

        if(isset($_POST['deposit']))
        {

            $balance=$balance+$_POST['amount'];

           // $sql = "INSERT INTO accounts ( withdraw, balance) VALUES ('".$_POST['amount']."','".$balance."')";

           $sql="INSERT INTO `accounts`( `deposit`, `balance`) VALUES ('".$_POST['amount']."','".$balance."')";

          // echo $sql;
           
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            
        }


        

        

       



    ?>
    <div class="account-details-container">
        <div class="header">
            <h1>Your Account Details</h1>
        </div>
        <div class="details">
          
            <div class="account-info">
                <p><strong>Account Number:</strong> </p>
                <p><strong>Account Type:</strong> </p>
                <p><strong>Account Holder:</strong></p>
            </div>
            <div class="balance">
                <p><strong>Account Balance:</strong> $</p>
                <p><strong>Available Balance:</strong> $</p>
            </div>
            <hr>
            <form method="post" action="">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required>
                <button type="submit" name="deposit">Deposit</button>
                <button type="submit" name="withdraw">Withdraw</button>
            </form>
            <hr>
            <h2>Recent Transactions</h2>
            <table>
                <tr>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>

                <?php  
                
                $sql = "SELECT * FROM accounts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    ?>

                    <tr>
                        <td><?php  if($row['deposit']==0){ echo 'Withdraw'; }else if($row['withdraw']==0){ echo 'Deposit';} ?></td>
                        <td><?php  echo $row['balance']  ?></td>
                        <td></td>
                    </tr>

                    <?php 
                  //  echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                }
                } else {
                echo "0 results";
                }

                mysqli_close($conn);

                
                ?>
                
            </table>
            
        </div>
        <a href="index.html" class="logout-button">Logout</a>
    </div>
   
</body>
</html>
