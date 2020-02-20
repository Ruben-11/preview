<?php 

/*DOWNLOAD IMAGES AND SAVE INTO FOLDER*/


	/*Use this in your callback function -> acbottalk*/
	/*start*/

	$update = json_decode(file_get_contents("php://input"),true);
	$fileId = $update['message']['photo'][0]['file_id'];
	$mimeType = $update['message']['photo'][0]['mime_type'];

	$filePath = getFilePath($token,$fileId);
	$imgName = str_replace('photos/', '', $filePath);
	saveImg("https://api.telegram.org/file/bot$token/$filePath","$imgName");
	
	/*end*/

function getFilePath($token,$fileId){

	$website="https://api.telegram.org/bot".$token;
	$params=[
		'file_id'=>$fileId,
	];
	$ch = curl_init($website . '/getFile');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	$result = json_decode($result);
	curl_close($ch);
	return $result->result->file_path;
}
function saveImg($filePath,$imageName){
	$ch = curl_init($filePath);
	$fp = fopen('/home/subtitl9/public_html/achelpbot/telegram_images/'.$imageName, 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}