<?php
//Copyright (c) 2021, Susan V. Rodgers, Lila Avenue, LLC,  lilaavenue@gmail.com 
$listid = "";
if (isset ($_GET['list'])) {
    $listid = filter_input(INPUT_GET, "list", FILTER_SANITIZE_STRING) ;  
}
$username = file_get_contents ('data/username.txt');
$password = file_get_contents ('data/password.txt');
$oldlist = $newlist = "";
$listitem = "";
if ($_SERVER ["REQUEST_METHOD"] == "POST" ) {

    if (isset ($_POST['listitem'])) {
        $listitem = $_POST['listitem'];
    }
    
    if (isset ($_POST['submit-remove'])) {                
        if ($listitem !== "" && file_exists ("data/lists/" . $listitem . ".txt")) {          
            $oldname = "data/lists/" . $listitem . ".txt";
            $newname = "data/trash/list----" . $listitem . ".txt";
            rename ($oldname, $newname);
            echo "<h3>" . $listitem . " Removed </h3>";
       }
    }
    
    else if (isset ($_POST['submit-new'])) {
       
        if (isset(  $_POST['newlist'])) {
            if ($_POST['newlist'] !== "") {
                 $newlist = $_POST['newlist'];
                 if (preg_match('/[A-Za-z1-9]+/', $newlist)) {
           
                    if (file_exists ("data/lists/" . $newlist . ".txt")) {
                        echo "<h3>List: '" . $newlist . "' already exists.</h3>";
                    }
                    else {                
                        file_put_contents ("data/lists/" . $newlist . ".txt", "")  ;                     
                        echo "<h3>" . ucwords ($newlist)  . " Created.</h3>";                   
                    } 
                 }
            }  
        }
    }

    else if (isset ($_POST['submit-rename'])) {    
        if (isset($_POST['listitme'])) {
             $oldname = $_POST['listitem'];            
        }
        if (isset($_POST['newname'])) {
            if ($_POST['newname'] !== "") {
                $newname = $_POST['newname'];
                if (preg_match('/[A-Za-z1-9]+/', $newname)) {

                    $oldlist = "data/lists/" . $listitem . ".txt";
                    $newlist = "data/lists/" . $newname . ".txt";
                    if (file_exists ($newlist)){
                        echo "<div class = 'error'>list already exists</div>";
                    }
                    else {
                        //RENAME list FILE  
                        rename ($oldlist, $newlist); 
                    }
                }
            }
        }
    }
    else if (isset ($_POST['submit-credentials'])) { 
        
        if (isset ($_POST['username'])) {
            $username = $_POST['username'];
            file_put_contents ("data/username.txt", $username);
        }
        if (isset ($_POST['password'])) {
            $password = $_POST['password'];
            file_put_contents ("data/password.txt", $password);
        }        
    }
}

echo "<a class = 'adminbutton' href = 'index.php'>&larr; Return</a><br>";
?>


<div class = 'third-column'>             

    <h4>Add New List</h4><br>
    <form action="index.php?page=manage-lists" method="post" >               
        <input type = 'text' name = 'newlist' value = '' /><br>
        <input class = 'submitbutton' type = 'submit'  value = 'Submit' name = 'submit-new'>        
    </form>

</div><div class = 'third-column'>  
        <h4>Remove List:</h4><br>
        <form action= "index.php?page=manage-lists" method="post" > 
            <?php
            $array1 = scandir ("data/lists");
            foreach ($array1 as $item) {    
              if ($item !== "." && $item !== ".." ) {  
                  $item = str_replace (".txt", "", $item);
                  echo  "<input type = 'radio' name = 'listitem' value =  '" . $item ."'>" . $item . " <br>"; 
               }
            } 
            ?>      
            <br><input class = 'submitbutton' type = 'submit'  value = 'Remove' name = 'submit-remove'> 
        </form> 

</div><div class = 'third-column'>
    <h4>Rename List:</h4><br>
    <form action= "index.php?page=manage-lists" method="post" > 
        <?php
        $array1 = scandir ("data/lists");
        foreach ($array1 as $item) { 

          if ($item !== "." && $item !== ".."   ) {  
               $item = str_replace (".txt", "", $item);
              echo  "<input type = 'radio' name = 'listitem' value =  '" . $item ."'>" . $item . " <br>"; 
           }
        } 
        ?>
        <br><br> <input type = 'text' name = 'newname' value = ''/><br>
        <input class = 'submitbutton' type = 'submit'  value = 'Rename' name = 'submit-rename'> 
    </form> 
</div>
<div class = 'third-column'>
<h2>Trash</h2>
   
<?php
$array1 = scandir ("data/trash");

foreach ($array1 as $item) { 

  if ($item !== "." && $item !== ".."   ) {  
       $item = str_replace (".txt", "", $item);
      echo  $item . " <br>"; 
   }
}  
    
?>
<br><a class = 'adminbutton' href = 'index.php?page=empty-trash'>Empty Trash</a>  
</div>

<div class = 'third-column'>
<h4>Update Username and Password</h4><br>
    <form method = 'post' action = 'index.php?page=manage-lists' >  

    <label for = 'username' >Username</label><br>
    <input id = 'username'  type = 'text' name = 'username'  value = '<?php echo $username; ?>'/>
    <br><br><label for = 'password'>Password</label><br>
    <input id = 'password' type = 'text' name = 'password'  value = '<?php echo $password; ?>'/> 
    <br><br><input class = 'submitbutton' type = 'submit' name = 'submit-credentials' value = 'Submit' /> 
    </form>         

</div>
  

