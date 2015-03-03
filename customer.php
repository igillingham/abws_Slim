<?php

$app->get('/customer/:id', function ($id) use ($app)
    {
    $db = db_connect();
    $db->autocommit ( FALSE );
    $stmt = $db->prepare ( 'SELECT id, name,address,email,phone_1,phone_2,notes FROM customer WHERE id=?' );
    $stmt->bind_param ( "i", $id );
    $stmt->execute ();
    $stmt->bind_result ( $id, $name,$address,$email,$phone_1,$phone_2,$notes );
    while ( $stmt->fetch () )
        {
        break;
        }
    $stmt->close ();
    $result = array("customer" => array ("id" => $id, "name" => $name, "address" => $address, "email" => $email, "phone_1" => $phone_1, "phone_2" => $phone_2, "notes" => $notes));
    $app->response->write(json_encode($result));

    $db->close ();

    });

$app->get('/customers/', function () use ($app)
    {
    $db = db_connect();
    $query = 'SELECT id, name FROM customer WHERE 1';
    $result = $db->query($query);

    /* associative array */
    while($row = $result->fetch_array(MYSQLI_ASSOC))
        {
        $rows[] = $row;
        }

    /* free result set */
    $result->free();
    $db->close ();

    $result = array("customers" => $rows);
    $app->response->write(json_encode($result));
    });

