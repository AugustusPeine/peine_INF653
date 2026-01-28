<?php
//Challenge 4
    //Grade
    $grade = 85;
    echo "Input: $grade<br>";

    //Find and display corresponding letter grade
    if ($grade >= 90) {
        echo "You got an A!";
    } elseif ($grade >= 80) {
        echo "You got a B!";
    } elseif ($grade >= 70) {
        echo "You got a C!";
    } elseif ($grade >= 60) {
        echo "You got a D!";
    } else {
        echo "You got an F!";
    }
?>