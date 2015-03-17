<?php
// handle GET requests for /print/:id
$app->get('/print/:id', function ($id) use ($app)
    {
    try
        {
        // query database for single medium record
        $record = R::load('printcopy', $id);

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

// handle GET requests for /prints
$app->get('/prints', function () use ($app)
    {
    try
        {
        // query database for all printers
        $records = R::getAll('SELECT id,artwork_id,limited_edition_serial from printcopy');
        if ($records)
            {
            // send response header for JSON content type
            $app->response()->header('Content-Type', 'application/json');
            // return JSON-encoded response body with query results
            // first wrapping in an outer context 'mediums'
            $result = array('prints' => $records);
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

// handle GET requests for /prints
$app->get('/prints/artwork/:id', function ($id) use ($app)
    {
    try
        {
        // query database for all printers
        $records = R::findAll('printcopy', 'artwork_id=?', array($id));
        if ($records)
            {
            // send response header for JSON content type
            $app->response()->header('Content-Type', 'application/json');
            // return JSON-encoded response body with query results
            // first wrapping in an outer context 'mediums'
            $result = array('prints' => $records);
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




