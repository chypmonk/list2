<?php   
$listid = $string = "";
if (isset ($_GET["list"])){   
    $listid = filter_input(INPUT_GET, "list", FILTER_SANITIZE_STRING) ;  
    $string = file_get_contents ('data/lists/' . $listid . ".txt");
}


if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {      
  
    if (isset ($_POST['key'])) {
        $key = $_POST['key'];
        if (isset ($_POST['value'])) {
            $value = $_POST['value'];
            file_put_contents ('data/lists/' . $key . ".txt", $value);
             $string = file_get_contents ('data/lists/' . $listid . ".txt");
        }
    }
} 
echo "<div class = 'two-thirds-column'>";
echo "<h3>" . ucwords (str_replace("-", " ",  $listid ))  . "</h3>";

echo "<form method = 'post' action = 'index.php?page=update-list&list=" . $listid . "'>";   
echo "<input type = 'hidden' name = 'key' value = '" . $listid . "' />";            
echo  "<textarea  name =  'value' rows = '10' cols = '60'>" . $string. " </textarea><br>" ;         
echo "<br><input type = 'submit' class = 'submitbutton' name = 'submit' value = 'Update' />"; 
echo "</form>";
echo "</div>";
echo "<a class = 'adminbutton' href = 'index.php?page=home'>&larr; Return</a>";

?>