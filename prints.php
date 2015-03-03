<?php

$app->get('/prints/id/:awid', function ($awid) use ($app)
    {

    $db = db_connect();
    $query = 'SELECT printcopy.limited_edition_serial, artwork.id, artwork.name FROM printcopy INNER JOIN artwork ON printcopy.artwork_id = artwork.id WHERE printcopy.artwork_id='.$awid.';';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        /*$rowalt = array("awid"=>$result("id"), "editionserial"=>$result("limited_edition_serial")*/
        $rows[] = $row;
        }
    
    /* free result set */
    $result->free();
    $db->close ();

	 $result = array("prints" => $rows);
    $app->response->write(json_encode($result));
    
    });


