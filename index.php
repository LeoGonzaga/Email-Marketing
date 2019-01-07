<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testando Email Marketing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
    <script src="script.js"></script>
</head>
<body>
        
<form method="POST" action="https://sacredlotus0529438.activehosted.com/proc.php" id="_form_1_" class="_form _form_1 _inline-form  _dark" novalidate>
  <input type="hidden" name="u" value="1" />
  <input type="hidden" name="f" value="1" />
  <input type="hidden" name="s" />
  <input type="hidden" name="c" value="0" />
  <input type="hidden" name="m" value="0" />
  <input type="hidden" name="act" value="sub" />
  <input type="hidden" name="v" value="2" />
  <div class="_form-content">
    <div class="_form_element _x91930502 _full_width _clear" >
      <div class="_form-title">
        Cadastre-se para receber atualizações por e-mail
      </div>
    </div>
    <div class="_form_element _x97946188 _full_width _clear" >
      <div class="_html-code">
        <p>
          Adicione uma mensagem descritiva dizendo o que seu visitante pode esperar aqui.
        </p>
      </div>
    </div>
    <div class="_form_element _x49104671 _full_width " >
      <label class="_form-label">
        E-mail*
      </label>
      <div class="_field-wrapper">
        <input type="text" name="email" placeholder="Digite seu e-mail" required/>
      </div>
    </div>
    <div class="_button-wrapper _full_width">
      <button id="_form_1_submit" class="_submit" type="submit" name="acao" value ="Enviar">
        Enviar
      </button>
    </div>
    <div class="_clear-element">
    </div>
  </div>
  <div class="_form-thank-you" style="display:none;">
  </div>
  <div class="_form-branding">
    <div class="_marketing-by">
      Marketing por
    </div>
    <a href="http://www.activecampaign.com" class="_logo"></a>
  </div>
</form>
</body>
</html>
<?php
    if(isset($_POST['email'])){
        $email = @$_POST['email'];
        echo $email;
    }

?>
<?php

// By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
$url = 'https://sacredlotus0529438.api-us1.com';


$params = array(

    // the API Key can be found on the "Your Settings" page under the "API" tab.
    // replace this with your API Key
    'api_key'      => 'c61bffb89a5aaf4484bdc29f299060a7afe13eab1fdf333cb9d400976929e3b3fb3725c5',

    // this is the action that adds a contact
    'api_action'   => 'contact_sync',

    // define the type of output you wish to get back
    // possible values:
    // - 'xml'  :      you have to write your own XML parser
    // - 'json' :      data is returned in JSON format and can be decoded with
    //                 json_decode() function (included in PHP since 5.2.0)
    // - 'serialize' : data is returned in a serialized format and can be decoded with
    //                 a native unserialize() function
    'api_output'   => 'serialize',
);

// here we define the data we are posting in order to perform an update
$post = array(
    'email'                    => $email,
    'first_name'               => '',
    'last_name'                => '',

    // any custom fields
    //'field[345,0]'           => 'field value', // where 345 is the field ID
    //'field[%PERS_1%,0]'      => 'field value', // using the personalization tag instead

    // assign to lists:
    'p[1]'                   => 1, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
    'status[1]'              => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
    //'form'          => 1001, // Subscription Form ID, to inherit those redirection settings
    //'noresponders[123]'      => 1, // uncomment to set "do not send any future responders"
    //'sdate[123]'             => '2009-12-07 06:00:00', // Subscribe date for particular list - leave out to use current date/time
    // use the folowing only if status=1
    'instantresponders[1]' => 0, // set to 0 to if you don't want to sent instant autoresponders
    //'lastmessage[123]'       => 1, // uncomment to set "send the last broadcast campaign"

    //'p[]'                    => 345, // some additional lists?
    //'status[345]'            => 1, // some additional lists?
);

// This section takes the input fields and converts them to the proper format
$query = "";
foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
$query = rtrim($query, '& ');

// This section takes the input data and converts it to the proper format
$data = "";
foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
$data = rtrim($data, '& ');

// clean up the url
$url = rtrim($url, '/ ');

// This sample code uses the CURL library for php to establish a connection,
// submit your request, and show (print out) the response.
if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

// If JSON is used, check if json_decode is present (PHP 5.2.0+)
if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
    die('JSON not supported. (introduced in PHP 5.2.0)');
}

// define a final API request - GET
$api = $url . '/admin/api.php?' . $query;

$request = curl_init($api); // initiate curl object
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

$response = (string)curl_exec($request); // execute curl post and store results in $response

// additional options may be required depending upon your server configuration
// you can find documentation on curl options at http://www.php.net/curl_setopt
curl_close($request); // close curl object

if ( !$response ) {
    die('Nothing was returned. Do you have a connection to Email Marketing server?');
}

// This line takes the response and breaks it into an array using:
// JSON decoder
//$result = json_decode($response);
// unserializer
$result = unserialize($response);
// XML parser...
// ...

// Result info that is always returned
echo 'Result: ' . ( $result['result_code'] ? 'SUCCESS' : 'FAILED' ) . '<br />';
echo 'Message: ' . $result['result_message'] . '<br />';

// The entire result printed out
echo 'The entire result printed out:<br />';
echo '<pre>';
print_r($result);
echo '</pre>';

// Raw response printed out
// echo 'Raw response printed out:<br />';
// echo '<pre>';
// print_r($response);
// echo '</pre>';

// // API URL that returned the result
// echo 'API URL that returned the result:<br />';
// echo $api;

// echo '<br /><br />POST params:<br />';
// echo '<pre>';
// print_r($post);
// echo '</pre>';?>