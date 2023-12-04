<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Results</title>
</head>
<body>

    <!-- Define Key Functions/!-->
    <?php 

    #Makes code readable
    function backButton() {
    print("<form action = \"userInfo.html\" method=\"post\">");
    print("<input type =\"submit\" value = \"Click here to head back to the main page\" />");
    exit();
    }

    #handles error cases
    function error($x) {
        #blank field error
        if ($x == 1) {
                print("<p>A field was left unanswered. Please click the button below to navigate back to the home page</p>");
        }

        #first name errors 
        if ($x == 2) {
            print("<p>Requirements not met for \"First Name\". Please include only letters, as well as limit input to a maximum of 20 characters</p>");
        }

        #last name errors
        if ($x == 3) {
            print("<p>Requirements not met for \"Last Name\". Please include only letters, as well as limit input to a maximum of 20 characters</p>");
        }
        #phone errors
        if ($x == 4) {
            print("<p>Requirements not met for \"Phone\". Please use the format xxx-xxx-xxxx with x = [0-9].</p>");
        }

        if ($x == 5) {
            print("<p>Requirements not met for \"Email\". Please use the format [letters and/or numbers]@[letters only].com or .edu with x = [0-9] and limit input to a maximum of 30 characters</p>");
        }

        backButton();
    
    }
    ?>

    <!-- Check each field for blank /!-->
    <?php 
        foreach ($_POST as $value) {
            if ($value == "") {
                error(1);
                break;
            }
            
        }
    ?>

   

    <!-- Initialize variables (didn't do this before so I wouldn't waste space)/!-->
    <?php 
    $firstName =($_POST['firstName']);
    $lastName =$_POST['lastName'];
    $phone =$_POST['phone'];
    $eMail =$_POST['eMail'];
    ?>

    <!-- LastName, First name is 20 characters or all letters /!-->
    <?php 
    if (strlen($firstName) > 20 || (ctype_alpha($firstName)==false)){
        error(2);
    }

    if (strlen($lastName) > 20 || (ctype_alpha($lastName)==false)){
        error(3);
    }
    ?>

    <!-- Phone must be in the format xxx-xxx-xxxx with x being a number 0-9  /!-->
    <?php
    if (preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)==0) {
        error(4);
    }
    ?>

    <!-- Email must be in the format "letters or numbers @letters.edu or .com  /!-->
    <?php
    if (preg_match("/^[a-zA-Z|0-9]+@[a-zA-Z]+(\.com|\.edu){1}$/", $eMail)==0 || strlen($eMail)>30) {
        error(5);
    }
    ?>

    <!-- Add to file  /!-->
    <?php
    $hand = fopen("userInfo.txt", "a");
    fwrite($hand, implode(":",[$lastName, $firstName, $phone, $eMail]),);
    fwrite($hand, "\n");
    fclose($hand);
    ?>


    <!-- Sort file in array/!-->
    <?php

    $lastNameArray = [];
    foreach (file("userInfo.txt") as $tempString) {
            if (ctype_space($tempString))
                continue;
            $lastNameArray[array_merge($lastNameArray, explode(":",trim($tempString)))[0]] = $tempString;
    }

    natcasesort($lastNameArray);
    ?>


    <!-- Provide HTML Table with Data  /!-->
    <table>   
        <tr class="header">
            <th><strong>Last Name</strong></th>
            <th><strong>First Name</strong></th>
            <th><strong>Phone</strong></th>
            <th><strong>Email</strong></th>
        <tr>
    
        <?php

            foreach ($lastNameArray as $rawData) {
                print("<tr>");

                $processedData=explode(":",$rawData);
                print("<td>".$processedData[0]."</td>");
                print("<td>".$processedData[1]."</td>"); 
                print("<td>".$processedData[2]."</td>"); 
                print("<td>".$processedData[3]."</td>"); 
                
                print("</tr>");
            }
            
        ?>

    </table>
    <!-- Overwrite file (write into new file w same name)  /!-->
    <?php 
        $hand = fopen("userInfo.txt", "w");
        foreach ($lastNameArray as $entry) {
            fwrite($hand, $entry);
            
        }
        fclose($hand);

    ?>


    <form action = "userInfo.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>