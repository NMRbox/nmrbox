#!/usr/bin/env php
<?php
function validate_ldap_password($name,$password)
{
	#this stuff should go in config file
	$host ='nmrbox-buildserver.cam.uchc.edu';
	$port = 5050;

	$addr = gethostbyname($host);
	$client = stream_socket_client("tcp://$addr:$port",$errno,$errorMessage);

	if ($client === false) {
	    throw new UnexpectedValueException("Failed to connect: $errorMessage");
	}

	$xml_request = new SimpleXMLElement('<ldap/>');
	$xml_request->addChild('user',$name);
	$xml_request->addChild('passwd',$password);
	$xml_request->addChild('operation','validate');
		
	$data = $xml_request->asXML( );
	fwrite($client, $data);
	$result = stream_get_contents($client);
	$xml_response = new SimpleXMLElement($result);
	foreach($xml_response as $key=>$value) {
		print($key . ' = '. $value . "\n");
		if ($key == 'status' && $value == 'success') {
			 return 1;
		}
	} 
	return 0;
}

function set_ldap_password($name,$password)
{
	#this stuff should go in config file
	$host ='nmrbox-buildserver.cam.uchc.edu';
	$port = 5050;

	$addr = gethostbyname($host);
	$client = stream_socket_client("tcp://$addr:$port",$errno,$errorMessage);

	if ($client === false) {
	    throw new UnexpectedValueException("Failed to connect: $errorMessage");
	}

	$xml_request = new SimpleXMLElement('<ldap/>');
	$xml_request->addChild('user',$name);
	$xml_request->addChild('passwd',$password);
	$xml_request->addChild('operation','set');
		
	$data = $xml_request->asXML( );
	fwrite($client, $data);
	$result = stream_get_contents($client);
	print($result);
	$xml_response = new SimpleXMLElement($result);
	foreach($xml_response as $key=>$value) {
		print($key . ' = '. $value . "\n");
		if ($key == 'status' && $value == 'success') {
			 return 1;
		}
	} 
	return 0;
}

if (count($argv) == 4) {

	#command line test, validate
	if ($argv[1] == 'validate') {
		$a = validate_ldap_password($argv[2],$argv[3]);
		print ("$a\n");
		return $a;
	}

	#command line test, set 
	else if ($argv[1] == 'set') {
		$a = set_ldap_password($argv[2],$argv[3]);
		print ("$a\n");
		return $a;
	}
}
print "Usage: " . $argv[0] . "[validate|set] [accountname] [password]";
return -1;
?>

