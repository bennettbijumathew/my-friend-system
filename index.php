<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <?php
        $message = "";
        $outcome = true; 

        // Opens a connection the SQL Server.
        require_once "settings.php";
        $connection = @mysqli_connect($host, $user, $password, $database) or die('<p>Failed to connect to server</p>');; 
        

        // This query creates a new table called 'friends' based on the existence of the 'friends' table. 
        $query = "
            CREATE TABLE IF NOT EXISTS friends (
                friend_id INT NOT NULL AUTO_INCREMENT, 
                friend_email VARCHAR(50) NOT NULL, 
                password VARCHAR(20) NOT NULL, 
                profile_name VARCHAR(30) NOT NULL, 
                date_started DATE NOT NULL, 
                num_of_friends INT UNSIGNED, 
                PRIMARY KEY (friend_id)
            );
        ";

        // Runs the query to SQL. If the query is false, add failure reason to the 'message' variable, and set the 'outcome' variable to false. 
        if (mysqli_query($connection, $query) == false) 
        {
            $outcome = false;
            $message .= "<p>The table 'friends' has not been created.</p>";
        }


        // This query selects all of the records from the 'friends' table. 
        $query = "
            SELECT * FROM friends;
        ";

        // Runs the query while setting the variable 'result' as the status of the query.
        $result = mysqli_query($connection, $query);

        // If the amount of rows in friends table is less than or equal to 0, insert new records. 
        if (mysqli_num_rows($result) <= 0) 
        {
            $query = "
                INSERT INTO friends (friend_id, friend_email, password, profile_name, date_started, num_of_friends) VALUES 
                (NULL, 'kevin@hotmail.com', 'pencilMan', 'Kevin Knowles', '2024-09-24', '2'), 
                (NULL, 'bennett@gmail.com', 'paloose', 'Bennett Biju Mathew', '2024-09-27', '2'), 
                (NULL, 'athena@gmail.com', 'password', 'Athena May', '2024-09-27', '1'), 
                (NULL, 'testerman@gmail.com', 'mcdonalds', 'Donald Jones', '2024-09-30', '3'), 
                (NULL, 'doeTrimming@yahoo.com', 'pencilslead', 'John Doe', '2024-10-01', '1'), 
                (NULL, 'sheila@gmail.com', 'whyyoulookinghuh?', 'Sheila Biju', '2024-09-25', '2'), 
                (NULL, 'nina-joseph@gmail.com', 'punoose', 'Nina Joseph ', '2024-09-05', '2'), 
                (NULL, 'jayLeeMusic@gmail.com', 'oldpassword', 'Jay Loe', '2024-09-04', '2'), 
                (NULL, 'denzel@gmail.com', 'lostangel', 'Denzel Mary', '2024-09-26', '3'), 
                (NULL, 'hines@hotmail.com', 'newPassword?', 'Valeria Hines', '2024-09-26', '2'),
                (NULL, 'admin@admin.com', 'admin', 'Mrs. Admin', '15/10/24', '3'), 
                (NULL, 'jose@universal.com', 'stoplooking??', 'Jose - Universal', '15/10/24', '0'), 
                (NULL, 'punoose@hotmail.com', 'newPassword', 'Punoose Baby', '16/10/24', '0');
            ";

            // Runs the query to SQL. If the query is false, add failure reason to the 'message' variable, and set the 'outcome' variable to false. 
            if (mysqli_query($connection, $query) == false) 
            {
                $outcome = false;
                $message .= "<p>The table 'friends' has not been populated.</p>";
            }
        }
        

        // This query creates a new table called 'myfriends' based on the existence of the 'myfriends' table. 
        $query = "
            CREATE TABLE IF NOT EXISTS myfriends (
                friend_id1 int(11) NOT NULL,
                friend_id2 int(11) NOT NULL,
                FOREIGN KEY (friend_id1) REFERENCES friends(friend_id),
                FOREIGN KEY (friend_id2) REFERENCES friends(friend_id)
            )
        ";

        // Runs the query to SQL. If the query is false, add failure reason to the 'message' variable, and set the 'outcome' variable to false. 
        if (mysqli_query($connection, $query) == false) 
        {
            $outcome = false;
            $message .= "<p>The table 'myfriends' has not been created.</p>";
        }


        // This query selects all of the records from the 'myfriends' table. 
        $query = "
            SELECT * FROM myfriends;
        ";
    
        // Runs the query to variable while setting the variable 'result' as the status of the query.
        $result = mysqli_query($connection, $query);
    
        // If the amount of rows in the 'myfriends' table is less than or equal to 0, insert new records. 
        if (mysqli_num_rows($result) <= 0) 
        {
            $query = "
                INSERT INTO `myfriends` (`friend_id1`, `friend_id2`) VALUES 
                ('1', '2'), 
                ('1', '5'), 
                ('2', '3'), 
                ('2', '6'), 
                ('3', '4'), 
                ('4', '5'), 
                ('4', '8'), 
                ('4', '9'), 
                ('5', '6'), 
                ('6', '7'), 
                ('6', '8'), 
                ('7', '4'), 
                ('7', '8'), 
                ('8', '3'), 
                ('8', '9'), 
                ('9', '2'), 
                ('9', '4'),
                ('9', '10'), 
                ('10', '1'), 
                ('10', '3'), 
                ('11', '4'),
                ('11', '8'),
                ('11', '9');
            ";
    
            // Runs the query to SQL. If the query is false, add failure reason to the 'message' variable, and set the 'outcome' variable to false. 
            if (mysqli_query($connection, $query) == false) 
            {
                $outcome = false;
                $message .= "<p>The table 'myfriends' has not been populated.</p>";
            }            
        }
    

        // If the outcome of the queries have worked, change message to match the current status. 
        if ($outcome == true) 
        {
            $message = "<p>Tables have been created and populated</p>";
        }

        // Closes the connection to SQL Server.
        mysqli_close($connection);
    ?>

    <div class="header">
        <h1>MY FRIEND SYSTEM</h1>    
        <p>the home page</p>
    </div>

    <div class="box"> 
        <div class="container">
            <h2>Welcome!</h2>
            <p>Welcome to the My Friend System where you can add friends. </p>
        </div>

        <div class="container">
            <h2>Disclaimer:</h2>
            <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student's work or from any other source.</p>
        </div>

        <div class="container">
            <h2>Database Status:</h2>
            <?php echo $message ?>
        </div>

        <div class="buttons">
            <button class="btn navigation-btn">
                <a href="signup.php">registration</a>
            </button>
            
            <button class="btn navigation-btn">
                <a href="login.php">log in</a>
            </button>
            
            <button class="btn navigation-btn">
                <a href="about.php">about</a>
            </button>
        </div>
    </div>
</body>
</html>