<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 
$conn = new mysqli($servername, $username, $password, $dbname);

 $response = array();


  if($_POST['KakaoID']){
    
    $id = $_POST['KakaoID'];
   
    $stmt = $conn->prepare("SELECT Name, Grade, Introduce, Profileimage, Personality, WakeupTime, SleepTime, Snoring, Noise, Hygiene, Smoking FROM profiles WHERE KakaoID = ?");
    $stmt->bind_param("s",$id);
    $result = $stmt->execute();

  if($result == TRUE){
     
        $response['error'] = false;
        $response['message'] = "Retrieval Successful!";
     
        $stmt->store_result();
        
        $stmt->bind_result($Name, $Grade, $Introduce, $Profileimage, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking);
        $stmt->fetch();
        $response['Name'] = $Name;
        $response['Grade'] = $Grade;
        $response['Introduce'] = $Introduce;
        $response['Profileimage'] = $Profileimage;
        $response['Personality'] = $Personality;
        $response['WakeupTime'] = $WakeupTime;
        $response['SleepTime'] = $SleepTime;
        $response['Snoring'] = $Snoring;
        $response['Noise'] = $Noise;
        $response['Hygiene'] = $Hygiene;
        $response['Smoking'] = $Smoking;
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
