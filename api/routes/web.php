<?php

$router->get('/profile', ['uses' => 'ProfileController@list']);
$router->get('/profile/{id}', ['uses' => 'ProfileController@get']);
$router->post('/profile', ['uses' => 'ProfileController@save']);
$router->delete('/profile/{id}', ['uses' => 'ProfileController@delete']);
