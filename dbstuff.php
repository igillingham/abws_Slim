<?php

// Helper method to get a string description for an HTTP status code
function getStatusCodeMessage($status)
	{
	// these could be stored in a .ini file and loaded
	// via parse_ini_file()... however, this will suffice
	// for an example
	$codes = Array (
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported' 
	);
	
	return (isset ( $codes [$status] )) ? $codes [$status] : '';
	}
	
	// Helper method to send a HTTP response code/message
function sendResponse($status = 200, $body = '', $content_type = 'text/html')
	{
	$status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage ( $status );
	header ( $status_header );
	header ( 'Content-type: ' . $content_type );
	echo $body;
	}
class ArtbaseAPI
	{
	private $db;
	
	// Constructor - open DB connection
	function __construct()
		{
		$this->db = new mysqli ( 'localhost', 'root', 'Eilidh1', 'artbase_dev' );
		$this->db->autocommit ( FALSE );
		}
		
		// Destructor - close DB connection
	function __destruct()
		{
		$this->db->close ();
		}
		
		// Main method to request data
	function getPrinter()
		{
		
		// Check for required parameters
		if (isset ( $_POST ["ab_printer_id"] ))
			{
			
			// Put parameters into local variables
			$ab_printer_id = $_POST ["ab_printer_id"];
			$name = "";
			
			// Look up code in database
			$user_id = 0;
			$stmt = $this->db->prepare ( 'SELECT id, printer_name, postcode FROM printer WHERE id=?' );
			$stmt->bind_param ( "i", $ab_printer_id );
			$stmt->execute ();
			$stmt->bind_result ( $id, $printer_name, $postcode );
			while ( $stmt->fetch () )
				{
				break;
				}
			$stmt->close ();
			
			// Return unlock code, encoded with JSON
			$result = array (
					"name" => $printer_name,
					"postcode" => $postcode 
			);
			sendResponse ( 200, json_encode ( $result ) );
			return true;
			}
		sendResponse ( 400, 'Invalid request' );
		return false;
		}
	}
	
	// This is the first thing that gets called when this page is loaded
	// Creates a new instance of the ArtbaseAPI class and calls the getPrinter method
$api = new ArtbaseAPI ();
$api->getPrinter ();

?>
