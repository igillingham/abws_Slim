<?php
// handle GET requests for /medium/:id
$app->get('/medium/:id', function ($id) use ($app)
    {
    try
        {
        // query database for single medium record
        $record = R::load('medium', 'id=?', $id);

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


// handle GET requests for /mediums
$app->get('/mediums', function () use ($app)
    {
    try
        {
        // query database for all mediums
        $mediums = R::getAll('SELECT * from medium');
        if ($mediums)
            {
            // send response header for JSON content type
            $app->response()->header('Content-Type', 'application/json');
            // return JSON-encoded response body with query results
            // first wrapping in an outer context 'mediums'
            $result = array('mediums' => $mediums);
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

$app->put('/medium/update/:id', function ($id) use ($app)
    {
    // get and decode JSON request body
    $request = $app->request();
    $body = $request->getBody();
    $input = json_decode($body);
    
    // store modified entry
    // return JSON-encoded response body
    //
    try
        {
        // query database for single entry
        $record = R::load('medium', 'id=?', $id);

        // store modified record
        // return JSON-encoded response body
        if ($record)
            {
            $record->medium = (string)$input->medium;
            R::store($record);
            $app->response()->header('Content-Type', 'application/json');
            echo json_encode(R::exportAll($record));
            }
        else
            {
            throw new ResourceNotFoundException();
            }
        }
    catch (ResourceNotFoundException $e)
        {
        $app->response()->status(404);
        }
    catch (Exception $e)
        {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
        }

    }
);
 

// handle POST requests to /medium
$app->post('/medium', function () use ($app)
    {
    try
        {
        // get and decode JSON request body
        $request = $app->request();
        $body = $request->getBody();
        $input = json_decode($body); 
        echo 'POST: body = '.$body.'  input = '.var_dump($input);
        // store medium record
        $record = R::dispense('medium');
        $record->medium = (string)$input->medium;
        $id = R::store($record);

        // return JSON-encoded response body
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode(R::exportAll($record));
        } 
    catch (Exception $e) 
        {
        echo 'POST exception! '.$e->getMessage();
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
        }
    }
);

// handle DELETE requests to /medium/:id
$app->delete('/medium/:id', function ($id) use ($app) 
    {
    try
        {
        // query database for record
        $request = $app->request();
        $record = R::load('medium', 'id=?', $id);

        // delete article
        if ($record)
            {
            R::trash($record);
            $app->response()->status(204);
            } 
        else 
            {
            throw new ResourceNotFoundException();
            }
        } 
    catch (ResourceNotFoundException $e) 
        {
        $app->response()->status(404);
        }
    catch (Exception $e)
        {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
        }
    });

