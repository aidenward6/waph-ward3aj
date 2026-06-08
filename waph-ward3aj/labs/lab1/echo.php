<?php
echo "<h1>Hello from PHP</h1>";
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    echo "Name: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
}
?>
