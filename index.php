<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>
	
</body>
</html>
<?php 
require __DIR__ . '/core.php';
require __DIR__ . '/vendor/autoload.php'; 

$tokenPath = 'token.json';

if( !file_exists($tokenPath) ){
	echo "Your token.json is not exist!";
}else{
	$client = display_data();
	$service = new Google_Service_Calendar($client);

	// Print the next 10 events on the user's calendar.
	$calendarId = 'primary';
	$optParams = array(
	  'maxResults' => 10,
	  'orderBy' => 'startTime',
	  'singleEvents' => true,
	  'timeMin' => date('c'),
	);
	$results = $service->events->listEvents($calendarId, $optParams);
	$events = $results->getItems();
	echo "<pre>";
	echo json_encode($events);
	echo "</pre>";

}

 ?>