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
   // on below line we are checking if our
   // table is having data with specific id.    
   if($result == TRUE){
         // if we get the response then we are displaying it below.
         $response['error'] = false;
         $response['message'] = "Retrieval Successful!";
         // on below line we are getting our result.
         $stmt->store_result();
         // on below line we are passing parameters which we want to get.
         $stmt->bind_result($Name, $Grade, $Introduce, $Profileimage, $Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking, $weighted);
         // on below line we are fetching the data.
         
         //Fetch into associative array
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
         // if the id entered by user donot exist then
         // we are displaying the error message
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }
    
  /*else{
      // if the user donot adds any parameter while making request
      // then we are displaying the error as insufficient parameters.
      $response['error'] = true; */
     
 

 
 // at last we are printing
 // all the data on below line.
 echo json_encode($response);
?>
