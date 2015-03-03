<?php

$app->get('/printformat/:id', function ($id) use ($app)
    {
    $db = db_connect();
    $db->autocommit ( FALSE );
    $stmt = $db->prepare ( 'SELECT id, name FROM printformats WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $id, $name );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();

    $result = array("printformat" => array ("id" => $id, "name" => $name));
    $app->response->write(json_encode($result));

    $db->close ();

    });


$app->get('/printformats/', function () use ($app)
    {
    $db = db_connect();
    $query = 'SELECT id, name FROM printformats WHERE 1';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }

    /* free result set */
    $result->free();
    $db->close ();

    $result = array("printformats" => $rows);
    $app->response->write(json_encode($result));
    });

