<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
include ("authentication.php");
include ("datetime.php");


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (mysqli_connect_errno())
  {
  $result_obj->status = "Failed";
         $result_obj->message = mysqli_connect_error();
         echo json_encode($result_obj); 
         exit;
  }else{
      #echo "successful connection";
  }
# Get JSON as a string
$json_str = file_get_contents('php://input');
#echo $json_str;

# Get as an object
$json_obj = json_decode($json_str,true);

$fuid =  $json_obj['fuid'];

if( !empty($fuid)){
    
    $rv = mysqli_query($conn,"SELECT `id`,`name`, `email`, `phone`, `fuid`, `profession` FROM `users` WHERE fuid = '".$fuid."'");
    //check if the insertion is successful
     $result_obj = new stdClass();
     $message = new stdClass();
    if($rv->num_rows != 0){
          $r = mysqli_fetch_assoc($rv);
          $result_obj->status = "Success";
          $message->name = $r["name"];
          $message->email = $r["email"];
          $message->id = $r["id"];
          $message->fuid = $r["fuid"];
          $result_obj->message = $message;
           echo json_encode($result_obj);
        
    }else{
     $result_obj->status = "Failed";
    $result_obj->message = "User not found";
     echo json_encode($result_obj);
    }
  
}else{
    $result_obj->status = "Failed";
    $result_obj->message = "Fields Missing";
     echo json_encode($result_obj);
   
}




mysqli_close($conn);
?>