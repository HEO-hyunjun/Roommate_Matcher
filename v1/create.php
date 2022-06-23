<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 
// connect with database demo
$conn = new mysqli($servername, $username, $password, $dbname);
 
 // an array to display response
 $response = array();

  // on below line we are checking if the parameter send is id or not.
  if($_POST['KakaoID']){
    // if the parameter send from the user id id then
    // we will search the item for specific id.
    $id = $_POST['KakaoID'];
       //on below line we are selecting the course detail with below id.
    $stmt = $conn->prepare("INSERT INTO profiles (KakaoID) VALUES (?)");
    $stmt->bind_param("s",$id);
    $result = $stmt->execute();
  // on below line we are checking if our
  // table is having data with specific id.
  if($result == TRUE){
        // if we get the response then we are displaying it below.
        $response['error'] = false;
        $response['message'] = "Retrieval Successful!";
        // on below line we are getting our result.
       
    } else{
        // if the id entered by user donot exist then
        // we are displaying the error message
        $response['error'] = true;
        $response['message'] = "Incorrect id";
    }
} else{
     // if the user donot adds any parameter while making request
     // then we are displaying the error as insufficient parameters.
     $response['error'] = true;
     $response['message'] = "Insufficient Parameters";
}
// at last we are printing
// all the data on below line.
echo json_encode($response);
?>
