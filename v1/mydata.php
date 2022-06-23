<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
 $response = array();


 if(isset($_POST['KakaoID'],
	$_POST['Personality'],
	$_POST['WakeupTime'],
	$_POST['SleepTime'],
	$_POST['Snoring'],
	$_POST['Noise'],
	$_POST['Hygiene'],
	$_POST['Smoking'])){

    
    
     
     $inputPersonality = $_POST['Personality'];
     $inputWakeupTime = $_POST['WakeupTime'];
     $inputSleepTime = $_POST['SleepTime'];
     $inputSnoring = $_POST['Snoring'];
     $inputNoise = $_POST['Noise'];
     $inputHygiene = $_POST['Hygiene'];
     $inputSmoking = $_POST['Smoking'];
     $inputKakaoID = $_POST['KakaoID'];

     

    }
    
    $stmt = $conn->prepare("UPDATE profiles SET Personality = ?, WakeupTime = ?, SleepTime = ?, Snoring = ?,Noise = ?, Hygiene = ?, Smoking = ? WHERE KakaoID = ?");
	$stmt->bind_param("ssssssss", $inputPersonality, $inputWakeupTime, $inputSleepTime, $inputSnoring, $inputNoise, $inputHygiene, $inputSmoking, $inputKakaoID);
    $result = $stmt->execute();
  
   if($result == TRUE){
      
         $response['error'] = false;
         $response['message'] = "Retrieval Successful!";
    
        

     } else{

         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    
   echo json_encode($response);
?>
