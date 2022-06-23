<?php
 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";
 

$conn = new mysqli($servername, $username, $password, $dbname);
 

 $response = array();


 if(isset($_POST['KakaoID'],
	$_POST['Gender'],
	$_POST['Dormitory'],
	$_POST['Personality'],
	$_POST['WakeupTime'],
	$_POST['SleepTime'],
	$_POST['Snoring'],
	$_POST['Noise'],
	$_POST['Hygiene'],
	$_POST['Smoking'])){

    
     $arr = [1,2,3,4,5,0];
    
     $inputKakaoID = $_POST['KakaoID'];
     $inputGender = $_POST['Gender'];
     $inputDormitory = $_POST['Dormitory'];

     if($_POST['Personality'] < 9){
        $inputPersonality = $_POST['Personality'];
        }
        else {$inputPersonality = implode($arr);}
        if($_POST['WakeupTime']  < 9){
        $inputWakeupTime = $_POST['WakeupTime'];
        }
        else {$inputWakeupTime = implode($arr);}
        if($_POST['SleepTime']  < 9){
        $inputSleepTime = $_POST['SleepTime'];
        }
        else {$inputSleepTime = implode($arr);}
        if($_POST['Snoring']  < 9){
        $inputSnoring = $_POST['Snoring'];
        }
        else {$inputSnoring = implode($arr);}
        if($_POST['Noise']  < 9){
        $inputNoise = $_POST['Noise'];
        }
        else {$inputNoise = implode($arr);}
        if($_POST['Hygiene']  < 9){
        $inputHygiene = $_POST['Hygiene'];
        }
        else {$inputHygiene = implode($arr);}
        if($_POST['Smoking']  < 9){
        $inputSmoking = $_POST['Smoking'];
        }
        else {$inputSmoking = implode($arr);}

    }
      
        $stmt = $conn->prepare("SELECT bot.Name, bot.Grade, bot.Introduce, bot.Profileimage, bot.Personality, bot.WakeupTime, bot.SleepTime, bot.Snoring, bot.Noise, bot.Hygiene, bot.Smoking,
        ((2*pow((top.Personality-bot.Personality),2))+ 
        (2*pow((top.WakeupTime-bot.WakeupTime),2))+ 
        (2*pow((top.SleepTime-bot.SleepTime),2))+
        (2*pow((top.Snoring-bot.Snoring),2))+ 
        (2*pow((top.Noise-bot.Noise),2))+
        (2*pow((top.Hygiene-bot.Hygiene),2))+ 
        (2*pow((top.Smoking-bot.Smoking),2))) as weighted
        FROM profiles top, profiles bot WHERE top.KakaoID = ? and top.KakaoID != bot.KakaoID and bot.Gender = ? and bot.Dormitory = ? and bot.Personality regexp CONCAT('[',?,']') and 
		bot.WakeupTime regexp CONCAT('[',?,']') and bot.SleepTime regexp CONCAT('[',?,']') and bot.Snoring regexp CONCAT('[',?,']') and bot.Noise regexp CONCAT('[',?,']') and 
		bot.Hygiene regexp CONCAT('[',?,']') and bot.Smoking regexp CONCAT('[',?,']') order by weighted");
        $stmt->bind_param("ssssssssss",$inputKakaoID, $inputGender, $inputDormitory, $inputPersonality, $inputWakeupTime, $inputSleepTime, $inputSnoring, $inputNoise, $inputHygiene, $inputSmoking);
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
