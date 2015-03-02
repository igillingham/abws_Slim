<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require 'vendor/autoload.php';
require 'database.php';

$app = new \Slim\Slim(array('debug' => true,
                            'log.enabled' => true,
                            'log.level' => \Slim\Log::DEBUG 
                        ));

$app->response->headers->set('Content-Type', 'application/json');
//$app->response->headers->set('Content-Type', 'text/plain');

require 'testers.php';
require 'artworks.php';
require 'prints.php';
require 'printers.php';

$app->run();

