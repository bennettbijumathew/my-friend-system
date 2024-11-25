<?php
    session_start();

    // If the variable for log in state has not been set, set a new variable to false.
    if (isset($_SESSION["logged_in"]) == false) 
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
    <title>Add Friends</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <div class="header">
        <h1>MY FRIEND SYSTEM</h1>    
        <p>add friends</p>
    </div>

    <form action="addfriend.php" method="POST" class="box"> 
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
                            <a href='signup.php'>register</a>
                        </button>
                    </div>
                ";

                // Stops the PHP Code from running.
                return;
            }   
        
            $current_user = $_SESSION["user_id"];
            $number_of_rows = 10;  
            $page = 1;

            // Changes the current page variable based on if the button has been been set. 
            if (isset($_GET["page"]) == true) 
            {
                $page = $_GET["page"];
            }

            // Opens a connection the SQL Server.
            require_once "settings.php";
            $connection = @mysqli_connect($host, $user, $password, $database) or die('<p>Failed to connect to server</p>');; 
            
            // Selects profile name from the 'friends' table where the id matches the user id inputted beforehand.
            $query = "
                SELECT profile_name, num_of_friends FROM friends
                WHERE friend_id = $current_user;
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

            // Selects the count of users who are not following the current user.
            $query = "
                SELECT DISTINCT COUNT(*) FROM friends 
                WHERE friend_id NOT IN (SELECT DISTINCT friend_id2 FROM myfriends WHERE friend_id1 = $current_user) 
                AND friend_id != $current_user;
            ";

            $result = mysqli_query($connection, $query);  
            
            // Determines the amount of pages by dividing count of non-friends with number of rows. It is then rounded up with ceil()
            $total_pages = ceil(mysqli_fetch_row($result)[0] / $number_of_rows);

            $first_row = ($page - 1) * $number_of_rows;

            // Selects a small group of ids and profile names of users who don't follow the current user.
            $query = "
                SELECT DISTINCT friend_id, profile_name, date_started FROM friends 
                WHERE friend_id NOT IN (SELECT DISTINCT friend_id2 FROM myfriends WHERE friend_id1 = $current_user) 
                AND friend_id != $current_user
                ORDER BY profile_name ASC
                LIMIT $first_row, $number_of_rows;
            ";

            $result = mysqli_query($connection, $query);  

            echo "<div class='container friends'>";

            // Loops through each row in query until there is no more rows to be found. 
            while ($row = mysqli_fetch_assoc($result)) 
            {          
                echo " 
                    <section> 
                        <div class='friend-detail'>
                            <h4>" . $row['profile_name'] . "</h4>
                            <p>Started on " . $row['date_started'] . "</p>
                        </div>

                        <button type='submit' value='" . $row['friend_id'] . "' name='id' class='btn friend-btn'>add</button>
                    </section>
                ";      
            }

            echo "<div class='page-buttons'>";

            // Creates buttons for each page. 
            for ($i = 1; $i <= $total_pages; $i++) 
            {      
                if ($i == $page) 
                {
                    echo "
                        <button class='btn page-btn' style='background-color: var(--secondary)'>
                            <a href='?page=$i'>$i</a>
                        </button>
                    ";
                }

                else 
                {
                    echo "
                        <button class='btn page-btn'>
                            <a href='?page=$i'>$i</a>
                        </button>
                    ";
                }
            }  
            
            echo "</div> </div>";
    
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
                <a href="friendlist.php" >friend list</a>
            </button>
        </div>
    </form>
</body>
</html>