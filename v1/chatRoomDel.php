<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "roommating";

// connect with database demo
$conn = new mysqli($servername, $username, $password, $dbname);

 // an array to display response

 $isAlready = 0;

 // on below line we are checking if the parameter send is id or not.
    if(isset($_POST['KakaoID1'], $_POST['KakaoID2'])){
        // if the parameter send from the user id id then
        // we will search the item for specific id.

        $inputKakaoIDMe = $_POST['KakaoID1'];
        $inputKakaoIDOther = $_POST['KakaoID2'];

        $stmt = $conn->prepare("UPDATE chatroom_tbl SET matched = 0 where (KakaoId1 = ? and KakaoId2 =?) or ( KakaoId1 = ? and KakaoId2 = ?)");
            $stmt->bind_param("iiii",$inputKakaoIDMe, $inputKakaoIDOther, $inputKakaoIDOther, $inputKakaoIDMe);
            $result = $stmt->execute();
    }


   if($result == TRUE){
         // if we get the response then we are displaying it below.
         $response['error'] = false;
         $response['message'] = "delete Successful!";
            }
   else{
         // if the id entered by user donot exist then
         // we are displaying the error message
         $response['error'] = true;
         $response['message'] = "Incorrect id";
     }

 // at last we are printing
 // all the data on below line.
 echo json_encode($response);
?>
                                                                                                                                66,2          Bot
