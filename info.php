<?php

$app->get('/print/id/:awid', function ($awid) use ($app)
    {
    
    $db = db_connect();
    $query = 'SELECT printcopy.limited_edition_serial, artwork.name FROM printcopy INNER JOIN artwork ON printcopy.artwork_id = artwork.id WHERE printcopy.artwork_id='.$awid.';';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }
    /* free result set */
    $result->free();
    $db->close ();

    $app->response->write(json_encode($rows));

    });


