<?php 
 
  require_once '../includes/DbOperation.php';
 
  function isTheseParametersAvailable($params){
 	
 	$available = true; 
 	$missingparams = ""; 
 
 	foreach($params as $param){
 		if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
 			$available = false; 
	 		$missingparams = $missingparams . ", " . $param; 
 		}		
 	}	
 	
 	if(!$available){
 		$response = array(); 
 		$response['error'] = true; 
 		$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
 
 		echo json_encode($response);
  		
 		die();
 	}
 }
 
 
 $response = array();
 
 
 if(isset($_GET['apicall'])){
 
 	switch($_GET['apicall']){
 
 		
 		case 'createprofile':
 		
 		isTheseParametersAvailable(array('KakaoID','Name','Grade','Introduce', 'Personality', 'WakeupTime', 'SleepTime', 'Snoring', 'Noise', 'Hygiene', 'Smoking', 'Language'));
 
 		$db = new DbOperation();
 
 		$result = $db->createProfile(
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
 
 
 		if($result){
 			
 			$response['error'] = false; 
 
 			
 			$response['message'] = 'Profile added successfully';
 
 			$response['profiles'] = $db->getProfiles();
 		}
		
		else{
 
 			$response['error'] = true; 
 
 			
 			$response['message'] = 'Some error occurred please try again';
 		}
 
 		break; 
 
 	
 		case 'getprofiles':
 		$db = new DbOperation();
 		$response['error'] = false; 
 		$response['message'] = 'Request successfully completed';
 		$response['profiles'] = $db->getProfiles();
 		break; 
 
 
 	 		case 'updateprofile':
 		isTheseParametersAvailable(array('KakaoID','Name','Grade','Introduce', 'Personality', 'WakeupTime', 'SleepTime', 'Snoring', 'Noise', 'Hygiene', 'Smoking', 'Language'));
 		$db = new DbOperation();
 		$result = $db->updateProfile(
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
 
 		if($result){
 			$response['error'] = false; 
 			$response['message'] = 'Profile  updated successfully';
 			$response['profiles'] = $db->getProfiles();
	 	}
		
		else{
 			$response['error'] = true; 
 			$response['message'] = 'Some error occurred please try again';
 		}
 		break; 
 
 		case 'deleteprofile':
 
 		if(isset($_GET['KakaoID'])){
 			$db = new DbOperation();
			
			if($db->deleteProfile($_GET['KakaoID'])){
 			$response['error'] = false; 
 			$response['message'] = 'Profile deleted successfully';
 			$response['profiles'] = $db->getProfiles();
 			}
			
			else{
 				$response['error'] = true; 
 				$response['message'] = 'Some error occurred please try again';
 			}		
 		
		}
		
		else{
 			$response['error'] = true; 
 			$response['message'] = 'Nothing to delete, provide an id please';
		}		
		
		break; 


//프로필 변경후 확인버튼 눌렀을 때 작동
		case'writeprofile';
		isTheseParametersAvailable(array('KakaoID','Name','Grade','Gender', 'Dormitory','Introduce','Profileimage'));
 		$db = new DbOperation();
 		$result = $db->writeProfile(
			$_POST['KakaoID'],
 			$_POST['Name'],
 			$_POST['Grade'],
			$_POST['Gender'],
			$_POST['Dormitory'],
 			$_POST['Introduce'],
			$_POST['Profileimage']
 		);
 
 		if($result){
 			$response['error'] = false;
 			$response['profiles'] = $db->geteveryProfiles();
	 	}
		
		else{
 			$response['error'] = true; 
 		}
 		break; 

		// 자신의 프로필요소들 1~5까지 체크한 뒤 확인 버튼 클릭시
		case'pickprofile';
		isTheseParametersAvailable(array('KakaoID', 'Personality', 'WakeupTime', 'SleepTime', 'Snoring', 'Noise', 'Hygiene', 'Smoking'));
 		$db = new DbOperation();
 		$result = $db->pickProfile(
			$_POST['KakaoID'],
 			$_POST['Personality'],
 			$_POST['WakeupTime'],
			$_POST['SleepTime'],
 			$_POST['Snoring'],
			$_POST['Noise'],
			$_POST['Hygiene'],
			$_POST['Smoking']
 		);
 
 		if($result){
 			$response['error'] = false; 
 			$response['profiles'] = $db->geteveryProfiles();
	 	}
		
		else{
 			$response['error'] = true; 
 		}
 		break;

		// 가중치에 따라 정렬해서 보여주는 경우
	case'sort';
		if(isset($_POST['KakaoID'],
				$_POST['Gender'],
				$_POST['Dormitory'])){
			$db = new DbOperation();
		   
		   if($db->sort($_POST['KakaoID'],
		 				$_POST['Gender'],
		  				$_POST['Dormitory'])){
			$response['profiles'] = $db->sort($_POST['KakaoID'],
											$_POST['Gender'],
											$_POST['Dormitory']);
			}
		   
		   else{
				$response['error'] = true;
			}		
		
	   }
	   
	   else{
			$response['error'] = true;
	   }		
	   
		break;

			case 'filterp';

	$arr = [1,2,3,4,5,0];

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
//$Personality, $WakeupTime, $SleepTime, $Snoring, $Noise, $Hygiene, $Smoking

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

$db = new DbOperation();

	if($db->filterp($_POST['KakaoID'],
					$_POST['Gender'],
					$_POST['Dormitory'],
					$inputPersonality,
					$inputWakeupTime,
					$inputSleepTime,
					$inputSnoring,
					$inputNoise,
					$inputHygiene,
					$inputSmoking)){
			$response['filter'] = $db->filterp(
										$_POST['KakaoID'],
										$_POST['Gender'],
										$_POST['Dormitory'],
										$inputPersonality,
										$inputWakeupTime,
										$inputSleepTime,
										$inputSnoring,
										$inputNoise,
										$inputHygiene,
										$inputSmoking);
			}

	break;

 	}
 
 }
 
 else{

 	$response['error'] = true; 
 	$response['message'] = 'Invalid API Call';
 }
 
 echo json_encode($response);
