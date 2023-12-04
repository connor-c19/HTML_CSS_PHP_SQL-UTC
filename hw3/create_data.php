<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Results</title>
</head>
<body>
    <!-- Initialize arrays /!-->
    <?php 
    $domains = [];
    $domainsFinal = [];
    $firstNames = [];
    $lastNames = [];
    $streetNames = [];
    $streetTypes = [];
    ?>

    <!-- Read text files, add data to array /!-->
        <?php 

        #domains
        foreach (file("hw3_data/domains.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $domains = array_merge($domains, explode(".",trim($tempString)));
        }
        $val = 0;
        foreach ($domains as $value) {
            if ($val%2 == 0) {
                array_push($domainsFinal, $domains[$val].".".$domains[$val+1]);
            }
            $val++;
        }
    


        #first names
        foreach (file("hw3_data/first_names.csv") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $firstNames = array_merge($firstNames, explode(",",trim($tempString)));
        }



        #last names
        foreach (file("hw3_data/last_names.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $lastNames = array_merge($lastNames, explode(",",trim($tempString)));
        }
    


        #street names
        foreach (file("hw3_data/street_names.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $streetNames = array_merge($streetNames, explode(":",trim($tempString)));
        }
    
        

        #street types
        foreach (file("hw3_data/street_types.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $streetTypes = array_merge($streetTypes, explode("..;",trim($tempString)));
        }
        ?>



    <!-- Print Arrays /!-->
    <pre>
        <?php
        print("<h3>Domains:</h3>");
        print_r($domainsFinal);

        print("<h3>First Names:</h3>");
        print_r($firstNames);

        print("<h3>Last Names:</h3>");
        print_r($lastNames);

        print("<h3>Street Names:</h3>");
        print_r($streetNames);

        print("<h3>Street Types:</h3>");
        print_r($streetTypes);


        ?>
    </pre>

    <!-- Generate HTML table  /!-->




    <table>   
        
    
    <tr class="header">
        <th><strong>First Name</strong></th>
        <th><strong>Last Name</strong></th>
        <th><strong>Address</strong></th>
        <th><strong>Email</strong></th>
    <tr>


    <?php 

        #lengths
        $firstNameLength = count($firstNames);
        $lastNameLength = count($lastNames);
        $streetNameLength = count($streetNames);
        $streetTypeLength = count($streetTypes);
        $domainLength = count($domainsFinal);

        #Main array 
        $randArray = [];
        #ancillary arrays for random value exclusion
        $firstArray = [];
        $lastArray = [];
        $streetArray = [];



        for($row = 0; $row < $firstNameLength; $row++) {
            print("<tr>");
            
            while( in_array( ($x = rand(0,$firstNameLength-1)), $firstArray ) );
            $randArray[$row][0] = $firstNames[$x];
                print("<td>".$randArray[$row][0]."</td>"); 
                $firstArray[] = $x;
            
            while( in_array( ($y = rand(0,$lastNameLength-1)), $lastArray ) );
            $randArray[$row][1] = $lastNames[$y];
                print("<td>".$randArray[$row][1]."</td>"); 
                $lastArray[] = $y;
            

            while( in_array( ($z = rand(0,$streetNameLength-1)), $lastArray ) );
            $randArray[$row][2] = rand(0,9999)." ".$streetNames[$z]." ".$streetTypes[rand(0,9)];
                print("<td>".$randArray[$row][2]."</td>"); 
                $streetArray[] = $z;

            $randArray[$row][3] = $randArray[$row][0].".".$randArray[$row][1]."@".$domainsFinal[rand(0, $domainLength-1)]."\n";
                print("<td>".$randArray[$row][3]."</td>"); 
            
            
            print("</tr>");
        }

        
    ?>
    </table>





    <!-- Write data into txt.txt /!-->
    <?php 
    
    for($row = 0; $row < $firstNameLength; $row++) {
        $hand = fopen("txt.txt", "a");
        fputs($hand, implode(":",$randArray[$row]));
  
    }
    ?>



    <form action = "html.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>