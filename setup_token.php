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
  <style type="text/css">
    body{
      display: flex;
      flex-direction: row;
      flex-wrap: nowrap;
      justify-content: center;
      align-items: center;
      align-content: stretch;
      height: 100vh;
    }
    .card{
      min-width: 60%;
    }
  </style>
<?php

require __DIR__ . '/core.php';

// Get the API client and construct the service object.
$client = setup_token();
$service = new Google_Service_Calendar($client);

$calendarId = 'primary';                                                                                                                                                   
$optParams = array(
  'maxResults' => 10,
  'orderBy' => 'startTime',
  'singleEvents' => true,
  'timeMin' => date('c'),
);
$tokenfile = 'token.json';
if( file_exists($tokenfile) ){
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();   
    
    echo "<h1>Your calendar API is established!</h1>";
    
}

?>

</body>
</html>
