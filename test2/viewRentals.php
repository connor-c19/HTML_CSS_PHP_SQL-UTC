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




    ##Query that gets films for each customer
    $query = "SELECT customer.first_name, customer.last_name, film.title
    FROM film
    INNER JOIN inventory on film.film_id = inventory.film_id
    INNER JOIN rental on inventory.inventory_id  = rental.inventory_id 
    INNER JOIN customer on rental.customer_id  = customer.customer_id 
    ORDER BY film.title"; 

    $stmt='';

    
    


    $query = "SELECT customer.first_name, customer.last_name, film.title, inventory.inventory_id, film.rental_rate, rental.return_date 
    FROM rental
    INNER JOIN customer on rental.customer_id  = customer.customer_id 
    INNER JOIN inventory on  rental.inventory_id  = inventory.inventory_id 
    inner join film on inventory.film_id = film.film_id 
    ORDER BY customer.last_name
    ;";



    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($first_name, $last_name, $film_title, $inventory_id, $rental_rate, $return_date);

        #initialize table
        printf("<table>");
        printf("<th><strong>First Name</strong></th>");
        printf("<th><strong>Last Name</strong></th>");
        printf("<th><strong>Film Title</strong></th>");
        printf("<th><strong>Inventory ID</strong></th>");
        printf("<th><strong>Rental Rate </strong></th>");
        printf("<th><strong>Return Date</strong></th>");
        #enter each value into table
        while ($stmt->fetch()) {


            print("<tr>");
        
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
            $first_name, $last_name, $film_title, $inventory_id, $rental_rate, $return_date);

            print("</tr>");
        }

        $stmt->close();


    }
    ?>


    <form action = "html.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>