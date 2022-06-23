<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";


$conn = new mysqli($servername, $username, $password, $dbname);


 $isAlready = 0;

 
    if(isset($_POST['KakaoID1'], $_POST['KakaoID2'])){
  

        $inputKakaoIDMe = $_POST['KakaoID1'];
        $inputKakaoIDOther = $_POST['KakaoID2'];

        $stmt = $conn->prepare("UPDATE chatroom_tbl SET matched = 0 where (KakaoId1 = ? and KakaoId2 =?) or ( KakaoId1 = ? and KakaoId2 = ?)");
            $stmt->bind_param("iiii",$inputKakaoIDMe, $inputKakaoIDOther, $inputKakaoIDOther, $inputKakaoIDMe);
            $result = $stmt->execute();
    }


   if($result == TRUE){
       
         $response['error'] = false;
         $response['message'] = "delete Successful!";
            }
   else{
        
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }

 echo json_encode($response);
?>
                                                                                                                                66,2          Bot
