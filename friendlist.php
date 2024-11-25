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
    <title>Friends List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <div class="header">
        <h1>MY FRIEND SYSTEM</h1>    
        <p>friends list</p>
    </div>

    <form action="unfriend.php" method="POST" class="box">
        <?php
            // If the user is not logged in, an error message will be displayed and the code won't proceed.
            if ($_SESSION["logged_in"] == false && $_SESSION["user_id"] == null) 
            {
                echo "
                    <div class='container'>
                        <h3>This page dosen't work without signing in :(</h3>
                        <p>You can log in or sign in from here:</p>
                    </div>

                    <div class='buttons'>
                        <button class='btn navigation-btn'>
                            <a href='login.php'>log in</a>
                        </button>

                        <button class='btn navigation-btn'>
                            <a href='signup.php'>registration</a>
                        </button>
                    </div>
                ";

                // Stops the PHP Code from running.
                return;
            }   

            $current_user = $_SESSION["user_id"]; 
            
            // Opens a connection the SQL Server.
            require_once "settings.php";
            $connection = @mysqli_connect($host, $user, $password, $database) or die('<p>Failed to connect to server</p>');; 
            
            // Selects profile name from the 'friends' table where the id matches the inputted user id.
            $query = "
                SELECT profile_name, num_of_friends FROM friends 
                WHERE friend_id = '$current_user';
            ";

            // The row is feteched onto a variable using the query. 
            $result = mysqli_query($connection, $query);  
            $result_row = mysqli_fetch_row($result);
        
            echo "
                <div class='container'>
                    <p>User: $result_row[0]</p>
                    <p>Amount of Friends: $result_row[1]</p>
                </div>
            ";


            // Selects id, and profile name of friends of the current user.
            $query = "
                SELECT DISTINCT friend_id, profile_name, date_started FROM friends 
                WHERE friend_id IN (SELECT DISTINCT friend_id2 FROM myfriends WHERE friend_id1 = $current_user) AND friend_id != $current_user 
                ORDER BY profile_name ASC;
            ";

            // The row is feteched onto a variable using the query. 
            $result = mysqli_query($connection, $query);  

            echo "<div class='container friends'>";

            // Loops through each row in query until there is no more rows to be found. 
            while ($row = mysqli_fetch_assoc($result))
            {
                echo " 
                    <section> 
                        <div class='friend-detail'>
                            <h2>" . $row['profile_name'] . "</h2>
                            <p>Started on " . $row['date_started'] . "</p>
                        </div>

                        <button type='submit' value='" . $row['friend_id'] . "' name='id' class='btn friend-btn'>unfriend</button>
                    </section>
                ";      
            }
            
            echo "</div>";

            // Closes the connection to SQL Server.
            mysqli_close($connection);
        ?>

        <div class="buttons">
            <button class="btn navigation-btn">
                <a href="logout.php">log out</a>
            </button>
        
            <button class="btn navigation-btn">
                <a href="index.php">home</a>
            </button>

            <button class="btn navigation-btn" style="background-color: var(--secondary)">
                <a href="friendadd.php" >add friends</a>
            </button>
        </div>
    </form> 
</body>
</html>
