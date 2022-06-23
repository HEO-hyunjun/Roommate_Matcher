<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 

$conn = new mysqli($servername, $username, $password, $dbname);
 

 $response = array();


  if($_POST['KakaoID']){

    $id = $_POST['KakaoID'];
    
    $stmt = $conn->prepare("INSERT INTO profiles (KakaoID) VALUES (?)");
    $stmt->bind_param("s",$id);
    $result = $stmt->execute();

  if($result == TRUE){
       
        $response['error'] = false;
        $response['message'] = "Retrieval Successful!";
    
       
    } else{
      
        $response['error'] = true;
        $response['message'] = "Incorrect id";
    }
} else{
    
     $response['error'] = true;
     $response['message'] = "Insufficient Parameters";
}

echo json_encode($response);
?>
