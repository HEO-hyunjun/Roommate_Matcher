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
 if(isset($_POST['KakaoID'],
	$_POST['Personality'],
	$_POST['WakeupTime'],
	$_POST['SleepTime'],
	$_POST['Snoring'],
	$_POST['Noise'],
	$_POST['Hygiene'],
	$_POST['Smoking'])){
     // if the parameter send from the user id id then
     // we will search the item for specific id.
    
    
    
     
     $inputPersonality = $_POST['Personality'];
     $inputWakeupTime = $_POST['WakeupTime'];
     $inputSleepTime = $_POST['SleepTime'];
     $inputSnoring = $_POST['Snoring'];
     $inputNoise = $_POST['Noise'];
     $inputHygiene = $_POST['Hygiene'];
     $inputSmoking = $_POST['Smoking'];
     $inputKakaoID = $_POST['KakaoID'];

     

    }
        //on below line we are selecting the course detail with below id.
    $stmt = $conn->prepare("UPDATE profiles SET Personality = ?, WakeupTime = ?, SleepTime = ?, Snoring = ?,Noise = ?, Hygiene = ?, Smoking = ? WHERE KakaoID = ?");
	$stmt->bind_param("ssssssss", $inputPersonality, $inputWakeupTime, $inputSleepTime, $inputSnoring, $inputNoise, $inputHygiene, $inputSmoking, $inputKakaoID);
    $result = $stmt->execute();
   // on below line we are checking if our
   // table is having data with specific id.    
   if($result == TRUE){
         // if we get the response then we are displaying it below.
         $response['error'] = false;
         $response['message'] = "Retrieval Successful!";
         // on below line we are getting our result.
         //$stmt->store_result();
         // on below line we are passing parameters which we want to get.
        

     } else{
         // if the id entered by user donot exist then
         // we are displaying the error message
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    
   echo json_encode($response);
?>
