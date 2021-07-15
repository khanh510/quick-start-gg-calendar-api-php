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
	<form action="" method="get">
		<div class="form-group">
			<label for="date"></label>
			<input type="date" name="date" id="date" class="form-control">	
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Search</button>
		</div>
		
	</form>
<?php 
require __DIR__ . '/core.php';
require __DIR__ . '/vendor/autoload.php'; 

$tokenPath = 'token.json';

if( !file_exists($tokenPath) ){
	echo "Your token.json is not exist!";
}else{
	$client = display_data();
	$service = new Google_Service_Calendar($client);
	if( isset($_GET['date'])&& !empty($_GET['date']) ){
		$date = $_GET['date'];
		$date = date("Y-m-d",strtotime("this week",strtotime($date)));
	 	$start = date("c", strtotime("-1 day",strtotime($date)) );
	 	$end = date("c", strtotime("+5 days",strtotime($date)) );
	}else{
		$date = date("Y-m-d",strtotime("this week"));
	 	$start = date("c", strtotime("-1 day",strtotime($date)) );
	 	$end = date("c", strtotime("+6 days",strtotime($date)) );
	}
	

	// Print the next 10 events on the user's calendar.
	$calendarId = 'primary';
	$optParams = array(
	  'maxResults' => 10,
	  'orderBy' => 'startTime',
	  'singleEvents' => true,
	  'timeMin' => $start,
	  'timeMax'	=> $end
	);
	$results = $service->events->listEvents($calendarId, $optParams);
	$events = $results->getItems();
	echo "<pre>";
	print_r($events);
	// print_r($service);
	echo "</pre>";

}

 ?>
</body>
</html>
