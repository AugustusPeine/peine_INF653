<?php
//Challenge 5
    //Input
    $year = 2024;
    echo "Input: $year<br>";

    //Check and display if leap year
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        echo "$year is a leap year.";
    } else {
        echo "$year is not a leap year.";
    }
?>