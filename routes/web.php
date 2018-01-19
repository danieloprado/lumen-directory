<?php

$router->get('/profile', ['uses' => 'ProfileController@list']);
$router->post('/profile', ['uses' => 'ProfileController@save']);
