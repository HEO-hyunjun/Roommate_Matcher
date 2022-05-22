<?php


require_once '../includes/DbOperation.php';


//API에 전달하는 파라미터들이 유효한지 확인하는 함수 
function isTheseParametersAvailable($params) {
     
    $available = true;
    $missingparams = "";

    foreach($params as $param){
        if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
            $available = false;
            $missingparams = $missingparams. ", ".$param;
        }
    }

     
    if (!$available) {
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters '.substr($missingparams, 1, strlen($missingparams)). ' missing';

        
        echo json_encode($response);

        
        die();
    }
}


$response = array();

//URL을 통한 API호출 (?apicall=[] 이 발생하면 []케이스에 따라 처리
if (isset($_GET['apicall'])) {

    switch ($_GET['apicall']) {

        case 'createprofile':
            isTheseParametersAvailable(array('KakaoID', 'Name', 'Grade', 'Introduce', 
                                             'Personality', 'WakeupTime', 'SleepTime', 'Snoring', 
                                             'Noise', 'Hygiene', 'Smoking', 'Language'));
            $db = new DbOperation();

            //profiles 테이블에 새로운 레코드 생성
            $result = $db -> createProfile(
                $_POST['KakaoID'],
                $_POST['Name'],
                $_POST['Grade'],
                $_POST['Introduce'],
                $_POST['Personality'],
                $_POST['WakeupTime'],
                $_POST['SleepTime'],
                $_POST['Snoring'],
                $_POST['Noise'],
                $_POST['Hygiene'],
                $_POST['Smoking'],
                $_POST['Language']
            );
            
            //레코드 생성에 성공했다는 메세지 출력
            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Profile added successfully';
                $response['profiles'] = $db -> getProfiles();
            }
            
            //레코드 생성에 실패했다는 오류 메세지 출력
            else {
                $response['error'] = true;
                $response['message'] = 'Some error occurred please try again';
            }

            break;
            
        //profiles 테이블에 존재하는 모든 레코드 출력
        case 'getprofiles':
            $db = new DbOperation();
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['profiles'] = $db -> getProfiles();
            break;


        //주어진 KakaoID에 해당하는 profiles 테이블 레코드를 새로운 입력값으로 변경
        case 'updateprofile':
            isTheseParametersAvailable(array('KakaoID', 'Name', 'Grade', 'Introduce', 
                                             'Personality', 'WakeupTime', 'SleepTime', 'Snoring', 
                                             'Noise', 'Hygiene', 'Smoking', 'Language'));
            $db = new DbOperation();
            $result = $db -> updateProfile(
                $_POST['KakaoID'],
                $_POST['Name'],
                $_POST['Grade'],
                $_POST['Introduce'],
                $_POST['Personality'],
                $_POST['WakeupTime'],
                $_POST['SleepTime'],
                $_POST['Snoring'],
                $_POST['Noise'],
                $_POST['Hygiene'],
                $_POST['Smoking'],
                $_POST['Language']
            );

            if ($result) {
                $response['error'] = false;
                $response['message'] = 'Profile  updated successfully';
                $response['profiles'] = $db -> getProfiles();
            }

            else {
                $response['error'] = true;
                $response['message'] = 'Some error occurred please try again';
            }
            break;

        //주어진 KakaoID에 해당하는 profiles 테이블 레코드 삭제
        case 'deleteprofile':

            //URL에서 (?apicall=deleteprofile&KakaoID=[])의 형태로 사용
            if (isset($_GET['KakaoID'])) {
                $db = new DbOperation();

                if ($db -> deleteProfile($_GET['KakaoID'])) {
                    $response['error'] = false;
                    $response['message'] = 'Profile deleted successfully';
                    $response['profiles'] = $db -> getProfiles();
                }

                else {
                    $response['error'] = true;
                    $response['message'] = 'Some error occurred please try again';
                }

            }

            else {
                $response['error'] = true;
                $response['message'] = 'Nothing to delete, provide an id please';
            }

            break;
    }

}

else {
    //API 호출에 실패하면 오류메세지 출력 
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

//response를 JSON형태로 출력 
echo json_encode($response);
