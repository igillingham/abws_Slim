<?php
// handle GET requests for /gallert/:id
$app->get('/gallery/:id', function ($id) use ($app)
    {
    try
        {
        // query database for single medium record
        $record = R::load('gallery', $id);

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

// handle GET requests for /galleries
$app->get('/galleries', function () use ($app)
    {
    try
        {
        // query database for all galleries
        $records = R::getAll('SELECT id,gallery_name from gallery');
        if ($records)
            {
            // send response header for JSON content type
            $app->response()->header('Content-Type', 'application/json');
            // return JSON-encoded response body with query results
            // first wrapping in an outer context 'mediums'
            $result = array('galleris' => $records);
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


