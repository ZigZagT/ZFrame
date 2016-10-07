<?php
/*
 * Copyright 2015 master.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
defined('ZEXEC') or define("ZEXEC", 1);
require_once '../base.php';

session_start();
?>

<?php
/*
  $applicationId = 'takedown';
  $password = 'sCSnlSPIB1e4/w/vYVYwh0uy';
  $fileName = 'myfile.jpg';
  // Get path to file that we are going to recognize
  $local_directory=dirname(__FILE__).'/images/';
  $filePath = $local_directory.'/'.$fileName;
  if(!file_exists($filePath))
  {
  die('File '.$filePath.' not found.');
  }
  if(!is_readable($filePath) )
  {
  die('Access to file '.$filePath.' denied.');
  }
  // Recognizing with English language to rtf
  // You can use combination of languages like ?language=english,russian or
  // ?language=english,french,dutch
  // For details, see API reference for processImage method
  $url = 'http://cloud.ocrsdk.com/processImage?language=english&exportFormat=rtf';

  // Send HTTP POST request and ret xml response
  $curlHandle = curl_init();
  curl_setopt($curlHandle, CURLOPT_URL, $url);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
  curl_setopt($curlHandle, CURLOPT_POST, 1);
  curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
  curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
  $post_array = array(
  "my_file"=>"@".$filePath,
  );
  curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_array);
  $response = curl_exec($curlHandle);
  if($response == FALSE) {
  $errorText = curl_error($curlHandle);
  curl_close($curlHandle);
  die($errorText);
  }
  $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
  curl_close($curlHandle);
  // Parse xml response
  $xml = simplexml_load_string($response);
  if($httpCode != 200) {
  if(property_exists($xml, "message")) {
  die($xml->message);
  }
  die("unexpected response ".$response);
  }
  $arr = $xml->task[0]->attributes();
  $taskStatus = $arr["status"];
  if($taskStatus != "Queued") {
  die("Unexpected task status ".$taskStatus);
  }

  // Task id
  $taskid = $arr["id"];

  // 4. Get task information in a loop until task processing finishes
  // 5. If response contains "Completed" staus - extract url with result
  // 6. Download recognition result (text) and display it
  $url = 'http://cloud.ocrsdk.com/getTaskStatus';
  $qry_str = "?taskid=$taskid";
  // Check task status in a loop until it is finished
  // Note: it's recommended that your application waits
  // at least 2 seconds before making the first getTaskStatus request
  // and also between such requests for the same task.
  // Making requests more often will not improve your application performance.
  // Note: if your application queues several files and waits for them
  // it's recommended that you use listFinishedTasks instead (which is described
  // at http://ocrsdk.com/documentation/apireference/listFinishedTasks/).
  while(true)
  {
  sleep(5);
  $curlHandle = curl_init();
  curl_setopt($curlHandle, CURLOPT_URL, $url.$qry_str);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
  curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
  curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
  $response = curl_exec($curlHandle);
  $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
  curl_close($curlHandle);

  // parse xml
  $xml = simplexml_load_string($response);
  if($httpCode != 200) {
  if(property_exists($xml, "message")) {
  die($xml->message);
  }
  die("Unexpected response ".$response);
  }
  $arr = $xml->task[0]->attributes();
  $taskStatus = $arr["status"];
  if($taskStatus == "Queued" || $taskStatus == "InProgress") {
  // continue waiting
  continue;
  }
  if($taskStatus == "Completed") {
  // exit this loop and proceed to handling the result
  break;
  }
  if($taskStatus == "ProcessingFailed") {
  die("Task processing failed: ".$arr["error"]);
  }
  die("Unexpected task status ".$taskStatus);
  }
  // Result is ready. Download it
  $url = $arr["resultUrl"];
  $curlHandle = curl_init();
  curl_setopt($curlHandle, CURLOPT_URL, $url);
  curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
  // Warning! This is for easier out-of-the box usage of the sample only.
  // The URL to the result has https:// prefix, so SSL is required to
  // download from it. For whatever reason PHP runtime fails to perform
  // a request unless SSL certificate verification is off.
  curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($curlHandle);
  curl_close($curlHandle);

  // Let user donwload rtf result
  header('Content-type: application/rtf');
  header('Content-Disposition: attachment; filename="file.rtf"');
  echo $response;
 * 
 */
?>

<?php
$time = time();
$content = Base::browser_request("http://211.68.160.18/");
$content = Base::browser_request("http://211.68.160.18/CheckCode.aspx", "_={$time}");
$content = explode('<!DOCTYPE', $content)[0];
$image = imagecreatefromstring($content);
var_dump($image);
$code = Base::browser_request("http://apis.baidu.com/apistore/idlocr/ocr", null, implode("&", [
        "fromdevice=pc",
        "clientip=10.10.10.0",
        "detecttype=Recognize",
        "languagetype=ENG",
        "imagetype=1",
        "image=" . urlencode(base64_encode($image))
    ]), [CURLOPT_HTTPHEADER => ["apikey: 3c5ecc3f7d598196fb488651dce94878", "Expect:"]]
);
$code = Base::browser_request("http://127.0.0.1/fileupload.php", null, [
            "assoc" => [
                "Filename" => "captcha",
                "sourcename" => "captcha",
                "sourcelanguage" => "cn",
                "desttype" => "txt",
                "Upload" => "Submit Query",
            ],
            "files" => ["captcha" => ["data" => $content, "type" => "image/gif"]]
                ]
);
echo $code;
//$doc = phpQuery::newDocumentHTML($content);
//$content = Base::browser_request("http://211.68.160.18/default2.aspx", NULL, $post);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>河北建筑工程学院选课工具</title>
    </head>
    <body>
        <div id="page">
            <?php
            //echo $content;
            ?>
        </div>
        <pre id="debug">
            <?php
            ?>
        </pre>
        <img src="data:image/jpg;base64,<?php echo base64_encode($content); ?>"/>
        <form method="post" action="http://127.0.0.1/joke.php" enctype="multipart/form-data">
            <input type="file" name="file1" id="file1" />
            <input type="submit" name="submit" value="upload" />
        </form>
        <form method="post" action="http://127.0.0.1/joke.php">
            <input type="file" name="file1" id="file1" />
            <input type="submit" name="submit" value="upload" />
        </form>
    </body>
</html>
