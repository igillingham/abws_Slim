<?php

$app->get('/prname/:id', function ($id)
    {
    $db = new mysqli ( 'localhost', 'root', 'Eilidh1', 'artbase_dev' );
    $db->autocommit ( FALSE );
    $stmt = $db->prepare ( 'SELECT id, printer_name, postcode FROM printer WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $id, $printer_name, $postcode );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();
    #$app->render('foo.php');
    echo "get printer name from id: $printer_name";

    $db->close ();

    });


