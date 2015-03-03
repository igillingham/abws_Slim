<?php

$app->get('/gallery/:id', function ($id) use ($app)
    {
    $db = db_connect();
    $db->autocommit ( FALSE );
    $stmt = $db->prepare ( 'SELECT id, gallery_name,street,town,postcode FROM gallery WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $id, $gallery_name,$street,$town,$postcode );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();
    $result = array("gallery" => array ("id" => $id, "gallery_name" => $gallery_name, "town" => $town, "postcode" => $postcode));
    $app->response->write(json_encode($result));

    $db->close ();

    });

$app->get('/galleries/', function () use ($app)
    {
    $db = db_connect();
    $query = 'SELECT id, gallery_name FROM gallery WHERE 1';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }

    /* free result set */
    $result->free();
    $db->close ();

    $result = array("galleries" => $rows);
    $app->response->write(json_encode($result));
    });
