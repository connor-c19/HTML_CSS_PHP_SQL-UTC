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

    
    #Use data from Query
    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($first_name, $last_name, $film_title);

        #Create associative array for customers and their respective rentals
        $film_title_multiple = ['key' => 'value'];

        while ($stmt->fetch()) {
            $film_title_multiple[$first_name.$last_name] = "";
        }

        #Re-execute statement to run through it again, adding rentals to their respective customers
        $stmt->execute();
        $stmt->bind_result($first_name, $last_name, $film_title);
        
        while ($stmt->fetch()) {
            #append statement
            $film_title_multiple[$first_name.$last_name] .= $film_title.", ";
        }

        $stmt->close();
        
    }


    $query = "SELECT customer.first_name, customer.last_name, address.address, city.city, address.district, address.postal_code 
    FROM customer
    INNER JOIN address on customer.address_id  = address.address_id 
    INNER JOIN city on address.city_id  = city.city_id 
    ORDER BY last_name";



    if ($stmt = $con->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($first_name, $last_name, $address, $city, $district, $postal_code);

        #initialize table
        printf("<table>");
        printf("<th><strong>First Name</strong></th>");
        printf("<th><strong>Last Name</strong></th>");
        printf("<th><strong>Address</strong></th>");
        printf("<th><strong>City</strong></th>");
        printf("<th><strong>District</strong></th>");
        printf("<th><strong>Postal Code</strong></th>");
        printf("<th><strong>Past Rentals</strong></th>");

        #enter each value into table
        while ($stmt->fetch()) {


            print("<tr>");
        
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
            $first_name, $last_name, $address, $city, $district, $postal_code, substr($film_title_multiple[$first_name.$last_name],0,strlen($film_title_multiple[$first_name.$last_name])-2));

            print("</tr>");
        }

        $stmt->close();


    }
    ?>


    <form action = "html.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>