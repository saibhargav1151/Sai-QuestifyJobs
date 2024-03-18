<?php
$router->get('/','HomeController@index');
$router->get('/listings','ListingController@index');
$router->get('/listings/create','ListingController@create');
$router->post('/listings','ListingController@store');

$router->get('/listings/{id}','ListingController@show');
$router->delete('/listings/{id}','ListingController@destroy');
$router->get('/listings/edit/{id}','ListingController@edit');
$router->put('/listings/{id}','ListingController@update' )
// $router->get('/','controllers/home.php');
// $router->get('/listings','controllers/listings/index.php');
// $router->get('/listing','controllers/listings/show.php');

// $router->get('/listings/create','controllers/listings/create.php');

?>