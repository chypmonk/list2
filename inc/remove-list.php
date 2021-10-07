<?php
//Copyright (c) 2021, Susan V. Rodgers, Lila Avenue, LLC,  lilaavenue@gmail.com 

$listid = "";
if (isset ($_GET["list"])){   
    $listid = filter_input(INPUT_GET, "list", FILTER_SANITIZE_STRING) ;  
}

if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {   
       
   if (isset($_POST ['removeflag'])) {      
      if ($_POST['removeflag'] === "REMOVE") {
             
          if ( file_exists ("data/lists/" . $listid . ".txt")) {          
            $oldname = "data/lists/" . $listid . ".txt";
            $newname = "data/trash/list----" . $listid . ".txt";
            rename ($oldname, $newname);
         }
      }  
   }
}

echo "<div class = 'content-column'>";

if (file_exists ("data/lists/" . $listid . ".txt")) {
    
    echo "<h2>Remove list: " .  $listid . "</h2>";    
    ?>
    <form method = 'post' action = 'index.php?page=remove-list&list=<?php echo $listid ;?>'>  

        <h3>Are you sure you want to move <?php echo $listid ; ?> to the Trash Bin?</h3><br>
        NO: <input type = 'radio' name = 'removeflag' value = '' checked />            
        YES <input type = 'radio' name = 'removeflag' value = 'REMOVE' />  
        <br><br><input class = 'submitbutton' type = 'submit' name = 'submit' value='Remove'/>

    </form>   
  <?php
}
else {
    echo "<h2>This list has been removed</h2>";
}
echo "</div><div class = 'sidebar-column'>";
echo "<a class = 'adminbutton' href = 'index.php?page=home'>&larr; Return</a><br>";

echo "</div>";

    
?>