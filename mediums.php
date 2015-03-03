<?php

$app->get('/medium/:id', function ($id) use ($app)
    {
    $db = db_connect();
    $db->autocommit ( FALSE );
    $stmt = $db->prepare ( 'SELECT id, medium FROM medium WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $id, $medium );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();
    $result = array("medium" => array ("id" => $id, "medium" => $medium));
    $app->response->write(json_encode($result));

    $db->close ();

    });

$app->get('/mediums/', function () use ($app)
    {
    $db = db_connect();
    $query = 'SELECT id, medium FROM medium';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }

    /* free result set */
    $result->free();
    $db->close ();

    $result = array("mediums" => $rows);
    $app->response->write(json_encode($result));
    });

