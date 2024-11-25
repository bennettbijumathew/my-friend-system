# my-friend-system

![Home Page](https://imgur.com/3MvVTc5.png "Home Page")

## Description
My Friend System is an application that provides a user a list of friends. 

The key features of the website include:
- Creating and logging in into accounts
- Adding or removing friends

This website was implemented using these tools: 
- MySQL
- PHP

## Project Setup
Before setting up the project, you would need these things:
- XAMPP with phpMyAdmin installed

### Adding the Required Tables
- Open the XAMPP Control Panel
- Start the Apache and MySQL.
- Click the 'Admin' Button of MySQL, you will be redirected to a phpMyAdmin website.
- Click into a database or create a new database
- Find the import button and choose the 'database.sql' and import it. This will create the tables 'myfriends' and 'friends' that are used within the website. 

### Running the Website
- Navigate to the htdocs folder within the base XAMPP folder such as 'C:\xampp\htdocs'
- Download the project folder and then place the folder inside inside the 'htdocs' folder.
- Go inside the project folder and open the 'settings.php' file. 
- Inside this file, you will have to change the details of the host, username, password and database to match your database setup.
- Once the settings were updated, the website is able to be accesed via url, an example of this is 'localhost/my-friend-system/index.php'.

# Website Photos
![Add Friends Page](https://imgur.com/qQooRT5.png "Add Friends Page")
![Friends List Page](https://imgur.com/QSOdx3f.png "Friends List Page")
![Log In Page](https://imgur.com/9yNiB6r.png "Friends List Page")
