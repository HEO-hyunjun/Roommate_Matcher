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
 if(isset($_POST['KakaoID'])){
     // if the parameter send from the user id id then
     // we will search the item for specific id.

     $arr = [1,2,3,4,5,0];

     $inputKakaoID = $_POST['KakaoID'];
 }
        //on below line we are selecting the course detail with below id.
    $stmt = $conn->prepare("SELECT P.KakaoId, P.Introduce, P.Profileimage, P.Name from chatroom_tbl R inner join profiles P on P.KakaoId = R.KakaoId2 where R.kakaoId1 = ?");
        $stmt->bind_param("i", $inputKakaoID);
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
         $stmt->bind_result($KakaoID, $Introduce, $Profileimage, $Name);
         // on below line we are fetching the data.


         //Fetch into associative array
         while ($stmt->fetch()) {
            $profile  = array();
            $profile['KakaoID'] = $KakaoID;
            $profile['Name'] = $Name;
            $profile['Introduce'] = $Introduce;
            $profile['Profileimage'] = $Profileimage;
            array_push($response, $profile);
       }
     } 
     else{
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
