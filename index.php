<?php

require_once __DIR__ . '/vendor/autoload.php';

use TheFox\Smtp\Server;
use TheFox\Smtp\Event;
/*
use Zend\Mail\Message;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Certificate data:
$dn = [
    'countryName' => 'UK',
    'stateOrProvinceName' => 'Isle Of Wight',
    'localityName' => 'Cowes',
    'organizationName' => 'Open Sauce Systems',
    'organizationalUnitName' => 'Dev',
    'commonName' => '127.0.0.1',
    'emailAddress' => 'info@opensauce.systems',
];

// Generate certificate
$privkey = openssl_pkey_new();
$cert = openssl_csr_new($dn, $privkey);
$cert = openssl_csr_sign($cert, null, $privkey, 365);

// Generate PEM file
$pem = [];
openssl_x509_export($cert, $pem[0]);
openssl_pkey_export($privkey, $pem[1]);
$pem = implode($pem);

print_r($pem);

// Save PEM file
$pemfile = __DIR__ . '/server.pem';
file_put_contents($pemfile, $pem);*/

$server = new Server();

$event = new Event(Event::TRIGGER_NEW_MAIL, null, function(Event $event, $from, $rcpts, $mail){
	// Do stuff: handle email, ...
	echo "Event: " . PHP_EOL;
	print_r($event);
	echo PHP_EOL . "=====================================================" . PHP_EOL;
	echo "From: " . PHP_EOL;
	print_r($from);
	echo PHP_EOL . "=====================================================" . PHP_EOL;
	echo "rcpts: " . PHP_EOL;
	print_r($rcpts);
	echo PHP_EOL . "=====================================================" . PHP_EOL;
	echo "mail: " . PHP_EOL;
	print_r($mail);
	echo PHP_EOL . "=====================================================" . PHP_EOL;
});
$server->addEvent($event);
$server->listen([
	'bindto' => '0.0.0.0:25'
]);
$server->loop();
