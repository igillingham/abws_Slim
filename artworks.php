<?php
$app->get('/artwork/:id', function ($id) use ($app)
    {
    try
        {
        // query database for single medium record
        //$record = R::findOne('artwork', 'id=?', array($id));
        $record = R::load('artwork', $id);

        if ($record)
            {
            // if found, return JSON response
            $app->response()->header('Content-Type', 'application/json');
            echo json_encode(R::exportAll($record));
            }
        else
            {
            // else throw exception
            throw new ResourceNotFoundException();
            }
        }
    catch (ResourceNotFoundException $e)
        {
        // return 404 server error
        $app->response()->status(404);
        }
    catch (Exception $e)
        {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
        }
    }
);


$app->get('/aw/name/:id', function ($id) use ($app)
    {
    try
        {
        // query database for single medium record
        //$record = R::findOne('artwork', 'id=?', array($id));
        $record = R::load('artwork', $id);

        if ($record)
            {
            // if found, return JSON response
            $app->response()->header('Content-Type', 'application/json');
            echo json_encode(R::exportAll($record));
            }
        else
            {
            // else throw exception
            throw new ResourceNotFoundException();
            }
        }
    catch (ResourceNotFoundException $e)
        {
        // return 404 server error
        $app->response()->status(404);
        }
    catch (Exception $e)
        {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
        }
    }
);



$app->get('/aw/details/:id', function ($id) use ($app)
    {

    $db = db_connect();
    $stmt = $db->prepare ( 'SELECT name,medium,present_location,original_selling_price, original_date_of_sale,limited_edition,number_sold,number_of_prints,information,image_filename,customer_id FROM artwork WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $artwork_name, $medium, $present_location, $original_selling_price, $original_date_of_sale, $limited_edition, $number_sold, $number_of_prints, $information, $image_filename, $customer_id );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();
    $result = array("artwork" => array ("id"     => $id, 
                                        "name"   => $artwork_name, 
                                        "medium" => $medium,
                                        "present_location" => $present_location,
                                        "original_selling_pric" => $original_selling_price,
                                        "original_date_of_sale" => $original_date_of_sale,
                                        "limited_edition" => $limited_edition,
                                        "number_sold" => $number_sold,
                                        "number_of_prints" => $number_of_prints,
                                        "information" => $information,
                                        "image_filename" => $image_filename,
                                        "customer_id" => $customer_id));
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

// handle GET requests for /artworks
$app->get('/artworks', function () use ($app)
    {
    try
        {
        // query database for all artworks
        $artworks = R::getAll('SELECT id, name from artwork');
        if ($artworks)
            {
            // send response header for JSON content type
            $app->response()->header('Content-Type', 'application/json');
            // return JSON-encoded response body with query results
            // first wrapping in an outer context 'mediums'
            $result = array('artworks' => $artworks);
            echo json_encode($result);
            }
        else
            {
            // else throw exception
            throw new ResourceNotFoundException();
            }
        }
    catch (ResourceNotFoundException $e)
        {
        // return 404 server error
        $app->response()->status(404);
        }
    catch (Exception $e)
        {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
        }
    }
);

