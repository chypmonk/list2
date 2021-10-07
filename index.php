<?php
//Copyright (c) 2021, Susan V. Rodgers, Lila Avenue, LLC,  lilaavenue@gmail.com 
session_start(); 

$loggedin = false;
if (isset ($_SESSION['admin']) ){
    if ($_SESSION['admin'] === true) {
        $loggedin = true;
    }
}

$pageid = "home";
if (isset ($_GET["page"])){   
    $pageid = filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING) ;     
}

include ("inc/header.php");

if ($_SERVER ["REQUEST_METHOD"] === "POST" ) { 
    if (isset ($_POST['submit-login'])) {
        if (isset ($_POST['username'])) {
            if (isset ($_POST['password']) ){
                $username = file_get_contents ('data/username.txt');
                $password = file_get_contents ('data/password.txt');                
                if ($username === $_POST['username'] && $password === $_POST['password']) {
                    $_SESSION['admin'] = true; 
                    $loggedin = true;
                }               
            }
        }
    }
}
if  ($loggedin === true) {
   
    if ($pageid === 'update-list') {
        include ("inc/update-list.php");
    } 
    if ($pageid === 'manage-lists') {
        include ("inc/manage-lists.php");
    }
    else if ($pageid === 'empty-trash'){
        include ("inc/empty-trash.php");
    }
    else if ($pageid === 'remove-list') {
        include ("inc/remove-list.php");
    }
    else if ($pageid === "home" ){
        //Default if front page
        echo "<div class = 'third-column current'>";
        echo "<h3>Current Lists:</h3>";
        $array1 = scandir ("data/lists");
        foreach ($array1 as $item1 ){   
            if ($item1 !== "." && $item1 !== ".."   ) {             
                $string = file_get_contents ('data/lists/' . $item1);  
                $listid = str_replace (".txt", "", $item1);

                echo "<br><a  href = 'index.php?page=update-list&list=" . $listid . "'><h4>" .  ucwords (str_replace("-", " ",  $listid ))  . "</h4></a>";        
            }
        }  

        echo "<br><a class = 'adminbutton'  href = 'index.php?page=manage-lists'>Manage Lists</a>";
         echo "</div>"; 
    }
   
}
else {
     $username = file_get_contents ('data/username.txt');
    $password = file_get_contents ("data/password.txt");
    ?> 
<h3>Log In</h3>
       <form method = "post" action= 'index.php'>
           <b>Username</b>
           <input   type="text"  name="username" value = "<?php echo $username; ?>"><br><br>
           <b>Password</b>
           <input   type="password"  name="password" value = "<?php echo $password; ?>" ><br>        
           <input class =   'submitbutton' type= "submit" value = "Enter" name = 'submit-login'>
       </form>
<?php     
}

include ("inc/footer.php");
?>
