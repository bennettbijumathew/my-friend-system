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
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">  
    <div class="header">
        <h1>MY FRIEND SYSTEM</h1>    
        <p>the registration page</p>
    </div>

    <form post="signup.php" method="POST" class="box">
        <div class="container inputs">
            <label for="email">Email Address:</label>
            <input type="text" name="email" id="email" value="<?php if (isset($_POST["email"]) == true) { echo $_POST["email"]; } ?>">
        </div>

        <div class="container inputs"> 
            <label for="profile">Profile Name:</label>
            <input type="text" name="profile" id="profile" value="<?php if (isset($_POST["profile"]) == true) { echo $_POST["profile"]; } ?>">
        </div>

        <div class="container inputs"> 
            <label for="first_password">Password:</label>
            <input type="password" name="first_password" id="first_password">
        </div>

        <div class="container inputs"> 
            <label for="second_password">Confirm Password:</label>
            <input type="password" name="second_password" id="second_password">
        </div>

        <div class="buttons">
            <input type="reset" value="reset" class="btn navigation-btn">
            <input type="submit" value="submit" class="btn navigation-btn" style="background-color: var(--secondary)">
        </div>

        <?php
            $message = "";
            $outcome = true; 
            $email = "";
            $profile = "";
            $first_password = "";
            $second_password = "";
            
            // Opens a connection the SQL Server.
            require_once "settings.php";
            $connection = @mysqli_connect($host, $user, $password, $database) or die('<p>Failed to connect to server</p>');; 

            // If the email input has been set, proceed with the rest of the code. 
            if (isset($_POST["email"]) == true) 
            {
                $email = $_POST["email"];

                // If the email input is empty, set message and outcome to false.
                if (empty($email) == true) 
                {
                    $message .= "<p>The input for the email is empty, please provide an input.</p>";
                    $outcome = false;
                }

                // This query selects from the friends table where the email matches the input.  
                $query = "
                    SELECT friend_email FROM friends WHERE friend_email = '$email'
                ";

                // Runs the query, while setting the variable 'result' as the status of the query.
                $result = mysqli_query($connection, $query);

                // If the amount of friends with the equivlent email to the input is greater than 0, then set message and outcome to false. 
                if (mysqli_num_rows($result) > 0) 
                {
                    $message .= "<p>The email has already been registered. Please try another email.</p>";
                    $outcome = false;
                }

                // If the pattern has not been found in the email, set message and outcome to false. 
                if (preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}/", $email) != 1) 
                {
                    $message .= "<p>The email needs to match a pattern such as 'name@email.com'</p>";
                    $outcome = false;
                }
            }

            // If email are not set, set outcome to false.
            else 
            {
                $outcome = false;
            }


            // If the profile input has been set, proceed with the rest of the code. 
            if (isset($_POST["profile"]) == true) 
            {
                $profile = $_POST["profile"];

                // If the profile input is empty, set message and outcome to false.
                if (empty($profile) == true) 
                {
                    $message .= "<p>The input for the profile is empty, please provide an input.</p>";
                    $outcome = false;
                }
                
                // If the pattern has not been found in the profile, set message and outcome to false. 
                if (preg_match("/^[a-zA-Z]+$/", $profile) != 1)
                {
                    $message .= "<p>The profile can only contain letters such as 'ExampleName'</p>";
                    $outcome = false;
                }
            }

            // If profile are not set, set outcome to false.
            else 
            {
                $outcome = false;
            }


            // If both passwords are set, proceed with the code. 
            if (isset($_POST["first_password"]) == true && isset($_POST["second_password"]))
            {
                $first_password = $_POST["first_password"];
                $second_password = $_POST["second_password"];

                // If the password has anything outside of letters and numbers, set message and outcome to false.
                if (preg_match("/^[a-zA-Z0-9]+$/", $first_password) != 1) 
                {
                    $message .= "<p>The password provided includes other symbols outside of letters and numbers, provide a different input.</p>";
                    $outcome = false;
                }

                // If the first password and the second password do not match, set message and outcome to false.
                if ($first_password != $second_password) 
                {
                    $message .= "<p>The passwords do not match.</p>";
                    $outcome = false;
                }
            }

            // If passwords are not set, set outcome to false.
            else 
            {
                $outcome = false;
            }


            // Checks if outcome is true, and proceeds as input is valid. 
            if ($outcome == true)
            {
                // Inserts new records into the 'friends' table using the valid input.
                $query = "
                    INSERT INTO friends (friend_id, friend_email, password, profile_name, date_started, num_of_friends) VALUES 
                    (NULL, '$email', '$first_password', '$profile', '" . date('Y-m-d') ." ', '0');
                ";

                // If the query has run, send user to the 'friendadd.php' page and set log in status to true. 
                if (mysqli_query($connection, $query) == true) 
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

                    // Sends user to the 'friendadd.php' page.
                    header('Location:friendadd.php');
                }

                // If the query hasn't run, set message. 
                else 
                {
                    $message .= "<p>The new account could not be made.</p>";
                }
            }

            // If the outcome is false, set message. 
            else 
            {
                $message .= "
                    <button class='btn message-btn'>
                        <a href='index.php'>home</a>
                    </button>
                ";
            }

            // If the inputs are set, a message is printed. 
            if (isset($_POST["email"]) == true && isset($_POST["profile"]) == true && isset($_POST["first_password"]) == true && isset($_POST["second_password"])) 
            {
                echo "
                    <div class='container'> 
                        <h2>Message:</h2>
                        $message
                    </div>
                ";
            }
        ?>
    </form>
</body>
</html>