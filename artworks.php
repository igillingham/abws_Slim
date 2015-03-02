<?php

$app->get('/aw/name/:id', function ($id) use ($app)
    {

    $db = db_connect();
    $stmt = $db->prepare ( 'SELECT name,medium FROM artwork WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $artwork_name, $medium );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();
    $result = array("artwork" => array ("id" => $id, "name" => $artwork_name, "medium" => $medium));
    //echo "get aw name from id: $artwork_name";
    $app->response->write(json_encode($result));
    $db->close ();

    });

$app->get('/aw/names/', function () use ($app)
    {
    $db = db_connect();
    $query = 'SELECT id, name FROM artwork';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }

    /* free result set */
    $result->free();
    $db->close ();

	$result = array("artworks" => $rows);
    $app->response->write(json_encode($result));
    });

