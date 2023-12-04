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
    function backButton() {
    print("<form action = \"userInfo.html\" method=\"post\">");
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


    #query that gets all of the films
    $query = "SELECT film.title, film.description, film.rental_duration, film.rental_rate, film.length, category.name, count(inventory.film_id)
    FROM film
    INNER JOIN film_category on film.film_id = film_category.film_id 
    INNER JOIN category on film_category.category_id  = category.category_id
    INNER JOIN inventory on  film.film_id = inventory.film_id
    group by inventory.film_id
    ORDER BY film.title
    ;";




    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($title, $description, $rental_duration, $rental_rate, $length, $category, $num_copies);

        #initialize table
        printf("<table>");
        printf("<th><strong>Title</strong></th>");
        printf("<th><strong>Description</strong></th>");
        printf("<th><strong>Rental Duration</strong></th>");
        printf("<th><strong>Rental Rate</strong></th>");
        printf("<th><strong>Length</strong></th>");
        printf("<th><strong>Category</strong></th>");
        printf("<th><strong>Number Of Copies</strong></th>");

        #enter each value into table
        while ($stmt->fetch()) {


            print("<tr>");
        
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
            $title, $description, $rental_duration, $rental_rate, $length, $category, $num_copies);

            print("</tr>");
        }

        $stmt->close();


    }
    ?>


    <form action = "html.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>