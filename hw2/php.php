<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Results</title>
</head>
<body>
    <!-- Initialize variables /!-->
    <?php 
    $numRow =$_POST['numRow'];
    $numCol =$_POST['numCol'];
    $minRandomVal =$_POST['minRandomVal'];
    $maxRandomVal =$_POST['maxRandomVal'];
    ?>

    <!-- Print info /!-->
    <h1>Your Array</h1>
    <?php 
    print("<p>Your array size is: $numRow x $numCol<p>");
    print("<p>Your min. value is: $minRandomVal<p>");
    print("<p>Your max. value is: $maxRandomVal<p>");
    ?>

    <!-- Initialize table /!-->
    <table>    
    <?php 
        $array = array();


        for($row = 0; $row < $numRow; $row++) {
            print("<tr>");
            for($col = 0; $col < $numCol; $col++){
                $array[$row][$col] = rand($minRandomVal, $maxRandomVal);
                print("<td>".$array[$row][$col]."</td>"); 
            }
            print("</tr>");
        }
        
    ?>
    </table>



    <!-- Buffer Space /!-->
    <br>



    <!-- Row/Sum/Avg/Std Dev /!-->
    <table>
        <tr class="header">
        <th><strong>Row</strong></th>
        <th><strong>Sum</strong></th>
        <th><strong>Avg</strong></th>
        <th><strong>Std Dev</strong></th>
        <tr>
    <?php 

        for($row = 0; $row < $numRow; $row++) {

            $rowSum = array_sum($array[$row]);
            $avg = $rowSum/$numCol;

            print("<tr>");
            print("<td>$row</td>");
            print("<td>$rowSum</td>");
            print("<td>".number_format($avg, 3,'.','')."</td>");
            $step3 = 0;
            for($col = 0; $col < $numCol; $col++){
                $step3 += pow($array[$row][$col]-$avg, 2);
            }
            print("<td>". number_format(pow($step3/$numRow, .5), 3,'.','')."</td>");
            print("</tr>");
        }
        
    ?>
    </table>

    <!-- Buffer Space /!-->
    <br>



    <!-- Pos/Neg/0 /!-->
    <table>
    <?php 

        for($row = 0; $row < $numRow; $row++) {
            print("<tr>");
            for($col = 0; $col < $numCol; $col++){
                print("<td>".$array[$row][$col]."</td>"); 
            }
            print("</tr>");

            print("<tr>");
            for($col = 0; $col < $numCol; $col++){

                if ($array[$row][$col] > 0) print("<td>positive</td>");
                elseif ($array[$row][$col] < 0) print("<td>negative</td>");
                else print("<td>zero</td>");

            }
            print("</tr>");



        }
        
    ?>
    </table>



   <!-- Buffer Space /!-->
   <br>



<form action = "html.html" method="post">
        <input type ="submit" value = "Click here to head back to the main page" />
</body>
</html>