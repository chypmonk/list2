<?php
//Copyright (c) 2021, Susan V. Rodgers, Lila Avenue, LLC,  lilaavenue@gmail.com 


$array1 = scandir ("data/trash");

if ($_SERVER ["REQUEST_METHOD"] == "POST" ) { 
    
    if (isset ($_POST['removeflag'])) {
        if ($_POST['removeflag'] === "REMOVE") {   
              
            foreach ($array1 as $item) {
                if ($item !== "." && $item !== "..") {
                    unlink("data/trash/" . $item);                    
                }
            }             
            $array1 = scandir ("data/trash");
        }
    }    
}

?>
<h2>Empty Trash</h2>
<div class = 'content-column'> 
   
      <?php  
 
       if (sizeof ($array1) === 2 ) {
           echo "<h3>Trash has been emptied</h3>";
       }
        else {
            echo "<form method = 'post' action = 'index.php?page=empty-trash'> ";
            
            echo "<h3>Empty Trash?</h3>";
            echo "NO: <input type = 'radio' name = 'removeflag' value = '' checked /> ";           
            echo "YES <input type = 'radio' name = 'removeflag' value = 'REMOVE' /> <br><br> ";  
            echo "<br><br><input class = 'submitbutton' type = 'submit' name = 'submit' value='Empty'/> ";
            echo "</form>";
        }       
        ?>
</div><div class = 'sidebar-column'>  
      <br><a class = 'adminbutton' href = 'index.php?page=home'>&larr; Return</a>
</div>    

  