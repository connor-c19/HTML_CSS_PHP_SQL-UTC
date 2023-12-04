<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Results</title>
</head>
<body>

    <?php
        $cities = [];
        $domains = [];
        $first_names = [];
        $last_names = [];
        $products = [];
        $states = [];
        $street_names = [];
        $street_types = [];
        $adjective = [];
        $color = [];
        $material = [];
        $verb = [];
        $warehouse_names = [];


        #cities
        foreach (file("input/cities.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $cities = array_merge($cities, explode(",",trim($tempString)));
        }
        $numCities = count($cities);

        #domains
        foreach (file("input/domains.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $domains = array_merge($domains, explode(",",trim($tempString)));
        }
        $numDomains = count($domains);

        #first_names
        foreach (file("input/first_names.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $first_names = array_merge($first_names, explode(",",trim($tempString)));
        }

        $numFirst_names = count($first_names);

        #last_names
        foreach (file("input/last_names.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $last_names = array_merge($last_names, explode(",",trim($tempString)));
        }

        $numLast_names = count($last_names);

        #products
        foreach (file("input/products.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $products = array_merge($products, explode(",",trim($tempString)));
        }

        $numProducts = count($products);

        #states
        foreach (file("input/states.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            if (empty($tempString)) {
                print("Is EMPTY\n");
            }
            $states = array_merge($states, explode(",",trim($tempString)));
        }

        $numStates = count($states);

        #street_names
        foreach (file("input/street_names.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $street_names = array_merge($street_names, explode(",",trim($tempString)));
        }

        $numStreet_names = count($street_names);

        #street_types
        foreach (file("input/street_types.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $street_types = array_merge($street_types, explode(",",trim($tempString)));
        }

        $numStreet_types = count($street_types);

        #adjective
        foreach (file("input/adjective.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $adjective = array_merge($adjective, explode(",",trim($tempString)));
        }

        $numAdjective = count($adjective);

        #color
        foreach (file("input/color.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $color = array_merge($color, explode(",",trim($tempString)));
        }

        $numColor = count($color);

        #material
        foreach (file("input/material.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $material = array_merge($material, explode(",",trim($tempString)));
        }

        $numMaterial = count($material);


        #verb
        foreach (file("input/verb.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $verb = array_merge($verb, explode(",",trim($tempString)));
        }

        $numVerb = count($verb);

        #warehouse_names
        foreach (file("input/warehouse_names.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $warehouse_names = array_merge($warehouse_names, explode(",",trim($tempString)));
        }

        $numWarehouse_names = count($warehouse_names);

    ?>


    <?php
        /*
        //List of foreign keys (to be referenced once primary keys are made)
        $addressIDArray = [];//(150)
        $customerIDArray = [];//(100)
        $orderIDArray = [];//(550)
        $productIDArray = [];//(750)
        $warehouseIDArray = [];//(25)
        */
    ?>

    <!--Generate records for address (150)-->
    <?php
        $hand = fopen("data.sql", "w");
        fputs($hand, "INSERT INTO address\n");
        fputs($hand, "VALUES");
        for ($x = 1; $x < 151; $x++) {#needs to be 151
            if ($x!= 1) {
                fputs($hand, ",");
            }
            fputs($hand, "\n");
            //address id##
            $addressID = $x;
            //street
            $street = rand(0,9999)." ".$street_names[rand(0,$numStreet_names-1)]." ".$street_types[rand(0,$numStreet_types-1)];
            //city 
            $city = $cities[rand(0,$numCities-1)];
            //state
            $state = $states[rand(0,$numStates-1)];
            //zip 
            $zip = str_pad(rand(0,99999), 5, 0, STR_PAD_LEFT);

            fputs($hand, "  ($addressID, \"$street\", \"$city\", \"$state\", $zip)");

        }
        fputs($hand, ";\n");
        print("<p>-Generated Data for Address Table</p>")
    ?>

    <!--Generate records for customer (100)-->
    <?php
        fputs($hand, "INSERT INTO customer\n(\ncustomer_id,\nfirst_name,\nlast_name,\nemail,\nphone,\naddress_id\n)\n");
        fputs($hand, "VALUES");
        for ($x = 1; $x < 101; $x++) { #needs to be 101
            if ($x!= 1) {
                fputs($hand, ",");
            }
            fputs($hand, "\n");
            //customer id##
            $customerID = $x;
            //first_name
            $first = $first_names[rand(0,$numFirst_names-1)];
            //last_name
            $last = $last_names[rand(0,$numLast_names-1)];
            //email
            $email = $last.$first.rand(0,99).$domains[rand(0,$numDomains-1)];
            //phone
            $phone = (rand(200,999) *10000000) + (rand(200,999)*10000) + (rand(0,9999)); #I chose 200 bc that's how U.S. phone #s are assigned
            
            //foreign key-- address id
            $foreignAddressID = rand(1,150);

            fputs($hand, "  ($customerID, \"$first\", \"$last\", \"$email\", $phone, $foreignAddressID)");

        }
        fputs($hand, ";\n");
        print("<p>-Generated Data for Customer");
    
    ?>

    <!--Generate records for order (350)-->

    <?php
    fputs($hand, "INSERT INTO order_\n(\norder_id,\ncustomer_id,\naddress_id\n)\n");
    fputs($hand, "VALUES");
    for ($x = 1; $x < 351; $x++) { #needs to be 351
        if ($x!= 1) {
            fputs($hand, ",");
        }
        fputs($hand, "\n");
        //order id##
        $orderID = $x;
               
        //foreign key--
        //customer_id
        $foreignCustomerID = rand(1,100);#needs to be 100
        //address id
        $foreignAddressID = rand(1,150);#needs to be 150
       

        fputs($hand, "  ($orderID, $foreignCustomerID, $foreignAddressID)");

    }
    fputs($hand, ";\n");
    print("<p>-Generated Data for Order");



    ?>


    <!--Generate records for product (750)-->

    <?php
    fputs($hand, "INSERT INTO product\n(\nproduct_id,\nproduct_name,\ndescription,\nweight,\nbase_cost\n)\n");
    fputs($hand, "VALUES");
    for ($x = 1; $x < 751; $x++) { #needs to be 751
        if ($x!= 1) {
            fputs($hand, ",");
        }
        fputs($hand, "\n");
        //primary key ##
        //product id
        $productID = $x;

        $productName = $products[rand(0, $numProducts-1)];
        $description = "A ".$adjective[rand(0,$numAdjective-1)]." ".$productName." in ".$adjective[rand(0,$numAdjective-1)]." ".$color[rand(0,$numColor-1)]." made of ".$material[rand(0,$numMaterial-1)]." useful for ".$verb[rand(0,$numVerb-1)].".";
        $weight = rand(1,100);
        $cost = rand(1,1000);

        fputs($hand, "  ($productID, \"$productName\", \"$description\",  $weight, $cost)");

    }
    fputs($hand, ";\n");
    print("<p>-Generated Data for Product");



    ?>

    <!--Generate records for warehouse (25)-->
    <?php
    fputs($hand, "INSERT INTO warehouse\n(\nwarehouse_id,\nname, \naddress_id\n)\n");
    fputs($hand, "VALUES");
    for ($x = 1; $x < 26; $x++) { #needs to be 751
        if ($x!= 1) {
            fputs($hand, ",");
        }
        fputs($hand, "\n");
        //primary key ##
        //product id
        $warehouseID = $x;

        $name = $warehouse_names[rand(0, $numWarehouse_names-1)];

        //foreign key-- address id
        $foreignAddressID = rand(1,150);#need to change to 150

        fputs($hand, "  ($warehouseID, \"$name\", $foreignAddressID)");

    }
    fputs($hand, ";\n");
    print("<p>-Generated Data for Warehouse");
    ?>

    <!--Generate records for order_item (550)-->

    <?php
    fputs($hand, "INSERT INTO order_item\n(\norder_id,\nproduct_id, \nquantity, \nprice\n)\n");
    fputs($hand, "VALUES");
    for ($x = 1; $x < 551; $x++) { #needs to be 551
        if ($x!= 1) {
            fputs($hand, ",");
        }
        //foreign key-- address id
        $orderID = rand(1,350);#need to change to 350
        $productID = rand(1,750);#need to change to 750
        $quantity = rand(1,100);#need to change to 350
        $price = rand(1,500);#need to change to 750


        fputs($hand, "  ($orderID, $productID, $quantity, $price)");

    }
    fputs($hand, ";\n");
    print("<p>-Generated Data for Order Item ");
    ?>


    <!--Generate records for product_warehouse - (1250)-->
    <?php
    fputs($hand, "INSERT INTO product_warehouse\n(\nproduct_id, \nwarehouse_id\n)\n");
    fputs($hand, "VALUES");
    for ($x = 1; $x < 1251; $x++) { #needs to be 1251
        if ($x!= 1) {
            fputs($hand, ",");
        }
        //foreign key-- address id
        $productID = rand(1,750);#need to change to 750
        $warehouseID = rand(1,25);#need to change to 25


        fputs($hand, "  ($productID, $warehouseID)");

    }
    fputs($hand, ";\n");
    print("<p>-Generated Data for Product Warehouse ");
    ?>


    <!--Create data.sql-->






    <form action = "userInfo.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>