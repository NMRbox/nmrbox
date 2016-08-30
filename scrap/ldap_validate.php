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

	$xml = new SimpleXMLElement('<ldap/>');
	$xml->addChild('user',$name);
	$xml->addChild('passwd',$password);
		
	$data = $xml->asXML( );
	fwrite($client, $data);
	$result = stream_get_contents($client);
	if ($result=='pass') {
	     return 1;
	}
	return 0;
}

#command line test
#$a = validate_ldap_password($argv[1],$argv[2]);
#print ($a);
?>
