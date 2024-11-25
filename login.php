<?php
    session_start();

    // If the log in state or user id has not been set, set the two variables.
    if (isset($_SESSION["logged_in"]) == false || isset($_SESSION["user_id"]) == false) 
    {
        $_SESSION["logged_in"] = false;
        $_SESSION["user_id"] = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <div class="header">
        <h1>MY FRIEND SYSTEM</h1>    
        <p>the log in page</p>
    </div>
  
    <form post="signup.php" method="POST" class="box">
        <div class="container inputs"> 
            <label for="email"> Email Address: </label>
            <input type="text" name="email" id="email" value="<?php if (isset($_POST["email"]) == true) { echo $_POST["email"]; } ?>">
        </div>

        <div class="container inputs"> 
            <label for="password"> Password: </label>
            <input type="password" name="password" id="password">
        </div>
        
        <div class="buttons">
            <input type="reset" class="btn navigation-btn" value="reset">

            <button class="btn navigation-btn">
                <a href='index.php'>home</a>
            </button>

            <input type="submit" class="btn navigation-btn" style="background-color: var(--secondary)" value="submit">
        </div>

        <?php
            $message = "";

            // Opens a connection the SQL Server.
            require_once "settings.php";
            $connection = @mysqli_connect($host, $user, $password, $database) or die('<p>Failed to connect to server</p>');; 


            // If the email input has been set, proceed with the rest of the code. 
            if (isset($_POST["email"]) == true && isset($_POST["password"]) == true) 
            {
                $email = $_POST["email"];
                $password = $_POST["password"];

                // This query selects from the friends table where the email matches the input.  
                $query = "
                    SELECT friend_email FROM friends WHERE friend_email = '$email' AND password = '$password';
                ";

                // Runs the query, while setting the variable 'result' as the status of the query.
                $result = mysqli_query($connection, $query);

                // If a friend with the equivlent email and password is equal to one, set log in session to true.  
                if (mysqli_num_rows($result) == 1) 
                {
                    // Selects ID from the 'friends' table where the record's email matches the input.
                    $query = "
                        SELECT friend_id FROM friends WHERE friend_email = '$email';
                    ";

                    // The row is feteched onto a variable using the query. 
                    $result = mysqli_query($connection, $query);
                    $user_id = mysqli_fetch_row($result)[0];

                    // Sets the logged in status to true and sets user id to the current user. 
                    $_SESSION["logged_in"] = true;
                    $_SESSION["user_id"] = $user_id;

                    // Sends user to the 'friendlist.php' page.
                    header('Location:friendlist.php');
                }

                // Sets the message when the log in wasn't successful.
                else 
                {
                    $message .= "<p>The details are incorrect, try another email or password </p>";
                }

                echo "
                    <div class='container'> 
                        <h2>Message:</h2>
                        $message
                    </div>
                ";
            }    

            // Closes the connection to SQL Server.
            mysqli_close($connection);
        ?>
    </form>
</body>
</html>