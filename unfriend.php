<?php
    session_start();

    // If the log in state or user id has not been set, set the two variables.
    if (isset($_SESSION["logged_in"]) == false || isset($_SESSION["user_id"]) == false) 
    {
        $_SESSION["logged_in"] = false;
        $_SESSION["user_id"] = null;
    }

    // Opens a connection the SQL Server.
    require_once "settings.php";
    $connection = @mysqli_connect($host, $user, $password, $database) or die('<p>Failed to connect to server</p>');; 

    // If the friend ID from the previous page has been set, proceed. 
    if (isset($_POST['id'])) 
    {
        $current_user = $_SESSION["user_id"];
        $friend_id = $_POST['id'];

        // Deletes the friends with the current user and the friend. 
        $query = "DELETE FROM myfriends WHERE friend_id1 = $current_user AND friend_id2 = $friend_id;";
        mysqli_query($connection, $query);

        // Selects the count of friends that the current user has.
        $query = "SELECT DISTINCT COUNT(myfriends.friend_id2) FROM friends INNER JOIN myfriends ON friends.friend_id=myfriends.friend_id1 WHERE myfriends.friend_id1 = $current_user;";
        $result = mysqli_query($connection, $query);

        // The query is feteched onto a variable using the query. 
        $result_row = mysqli_fetch_row($result);

        // Updates the number of friends for the current user.
        $query = "UPDATE friends SET num_of_friends = $result_row[0] WHERE friend_id = $current_user";
        mysqli_query($connection, $query);

        // Redirects user back to 'friendlist.php'
        header("Location:friendlist.php");
    }
?>