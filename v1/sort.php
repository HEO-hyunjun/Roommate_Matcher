<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
 $response = array();

 if(isset($_POST['KakaoID'], $_POST['Gender'],$_POST['Dormitory'])){
    
  
     $inputKakaoID = $_POST['KakaoID'];
     $inputGender = $_POST['Gender'];
     $inputDormitory = $_POST['Dormitory'];

    }
    
        $stmt = $conn->prepare("SELECT bot.Name, bot.Grade, bot.Introduce, bot.Profileimage, bot.Personality, bot.WakeupTime, bot.SleepTime, bot.Snoring, bot.Noise, bot.Hygiene, bot.Smoking,
        ((2*pow((top.Personality-bot.Personality),2))+ 
        (2*pow((top.WakeupTime-bot.WakeupTime),2))+ 
        (2*pow((top.SleepTime-bot.SleepTime),2))+
        (2*pow((top.Snoring-bot.Snoring),2))+ 
        (2*pow((top.Noise-bot.Noise),2))+
        (2*pow((top.Hygiene-bot.Hygiene),2))+ 
        (2*pow((top.Smoking-bot.Smoking),2))) as weighted
        FROM profiles top, profiles bot WHERE top.KakaoID = ? and top.KakaoID != bot.KakaoID and bot.Gender = ? and bot.Dormitory = ? order by weighted");
	$stmt->bind_param("sss", $inputKakaoID, $inputGender, $inputDormitory);
        $result = $stmt->execute();
 
   if($result == TRUE){
  
         $response['error'] = false;
         $response['message'] = "Retrieval Successful!";

         $stmt->store_result();

         $stmt->bind_result($Name, $Grade, $Introduce, $Profileimage, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking, $weighted);

         
     
         while ($stmt->fetch()) {          
            $profile  = array();
			$profile['Name'] = $Name; 
			$profile['Grade'] = $Grade;
			$profile['Introduce'] = $Introduce; 
			$profile['Profileimage'] = $Profileimage;
			$profile['Personality'] = $Personality;
			$profile['WakeupTime'] = $WakeupTime;
			$profile['SleepTime'] = $SleepTime; 
			$profile['Snoring'] = $Snoring;
			$profile['Noise'] = $Noise;
			$profile['Hygiene'] = $Hygiene;
			$profile['Smoking'] = $Smoking;
		   $profile['weighted'] = $weighted;  
   
			array_push($response, $profile); 
       } 

     } else{
 
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    
  /*else{
      
      $response['error'] = true; */ 

 

 echo json_encode($response);
?>
