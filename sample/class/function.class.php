<?php
    // Function for Cleaning the inputs in forms
    function clean($input)
    {
        // Trim() removes any whitespace or predefined characters from both sides of the input
        $input = trim($input);
        // stripslashes() removes backslashes for the input
        $input = stripslashes($input);
        // htmlspecialchars() converts special characters to their HTML entities 
        $input = htmlspecialchars($input);
        // Return the cleaned input string
        return $input;
    }