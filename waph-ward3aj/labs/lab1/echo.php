<?php
echo "<h1>Hello from PHP</h1>";

// check for input before processing
if (isset($_GET['name']) && trim($_GET['name']) !== '') {
    $name = $_GET['name'];
    
    // escape html tags to prevent xss usign utf-8 encoding
    echo "Name: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
} else {
    echo "Name: Please provide a valid name.";
}
?>
