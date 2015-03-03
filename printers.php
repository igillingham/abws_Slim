<?php

$app->get('/printer/:id', function ($id) use ($app)
    {
    $db = db_connect();
    $db->autocommit ( FALSE );
    $stmt = $db->prepare ( 'SELECT id, printer_name, town, street, postcode FROM printer WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $id, $printer_name, $town, $street, $postcode );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();

    $result = array("printer" => array ("id" => $id, "name" => $printer_name, "town" => $town, "street" => $street, "postcode" => $postcode));
    $app->response->write(json_encode($result));

    $db->close ();

    });


$app->get('/printers/', function () use ($app)
    {
    $db = db_connect();
    $query = 'SELECT id, printer_name FROM printer WHERE 1';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }

    /* free result set */
    $result->free();
    $db->close ();

    $result = array("printers" => $rows);
    $app->response->write(json_encode($result));
    });

