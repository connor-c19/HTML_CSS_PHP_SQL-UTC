<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Results</title>
</head>
<body>

    <!-- Initialize Variables/!-->
    <?php 


    $Title =$_POST['Title'];
    $Description =$_POST['Description'];
    $Release_Year =$_POST['Release_Year'];
    $Language_ID =$_POST['Language_ID'];

    $Rental_Duration =$_POST['Rental_Duration'];
    $Rental_Rate =$_POST['Rental_Rate'];
    $Length =$_POST['Length'];
    $Replacement_Cost =$_POST['Replacement_Cost'];

    $Rating =$_POST['Rating'];
    $Special_Features =$_POST['Special_Features'];
    ?>


    <?php
    function backButton() {
        print("Query was unsuccessful, please try again");
        print("<form action = \"html.html\" method=\"post\">");
        print("<input type =\"submit\" value = \"Click here to head back to the main page\" />");
        exit();
    }

    #SQL Integration

    $host = "localhost";
    $port = 3306;
    $socket = "";
    $user = "root";
    $password = "";
    $dbname = "sakila";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

    #$con->close();


    #Queury
    $query = "INSERT INTO sakila.film 
    (title,description,release_year,language_id,rental_duration,rental_rate,length,replacement_cost,rating,special_features) 
    VALUES (\"$Title\",\"$Description\",$Release_Year,$Language_ID,$Rental_Duration,$Rental_Rate,$Length,$Replacement_Cost,\"$Rating\",\"$Special_Features\")";

    try {
        if ($stmt = $con->prepare($query)) {
            $stmt->execute();
            $stmt->close();
        }
    }

    catch(Exception $e) {
       backButton();
    }

    print("Query Successful");
    ?>
    





    <form action = "html.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>