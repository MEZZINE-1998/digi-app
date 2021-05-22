<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
/*
Route::get('cvs','CvController@index');
Route::get('cvs/create','CvController@create');
Route::post('cvs','CvController@store');
Route::get('cvs/{id}/edit','CvController@edit');
Route::put('cvs/{id}','CvController@update');
Route::delete('cvs/{id}','CvController@destroy');
Route::get('cvs/{id}','CvController@show');
*/

// Route::get('/NewAccount', function () {
//     return view('auth.register');
// });

Route::resource('cvs','CvController');


Route::get('/livesearch','CvController@getIngs');


Route::get('/getexperience/{id}','CvController@getExperience');

Route::get('/getformation/{id}','CvController@getFormation');

Route::get('/getcompetence/{id}','CvController@getCompetence');



Route::post('/addexperience','CvController@addExperience');

Route::post('/addformation','CvController@addFormation');

Route::post('/addcompetence','CvController@addCompetence');




Route::put('/editexperience','CvController@editExperience');

Route::put('/editformation','CvController@editFormation');

Route::put('/editcompetence','CvController@editCompetence');




Route::delete('/deleteexperience/{id}','CvController@deleteExperience');

Route::delete('/deleteformation/{id}','CvController@deleteFormation');

Route::delete('/deletecompetence/{id}','CvController@deleteCompetence');



Auth::routes();

Route::get('/home', 'HomeController@index');



Route::get('user/{id}','EntrepriseController@index');
Route::post('user','EntrepriseController@store');
Route::get('user/{id}/edit','EntrepriseController@edit');

Route::get('/getRecrutement/{id}','EntrepriseController@getRecrutement');
Route::post('/addRecrutement','EntrepriseController@addRecrutement');
Route::put('/editRecrutement','EntrepriseController@editRecrutement');
Route::delete('/deleteRecrutement/{id}','EntrepriseController@deleteRecrutement');


Route::get('admin/{id}','AdminController@index');
Route::post('admin','AdminController@store');
Route::get('admin/{id}/edit','AdminController@edit');
Route::get('/getRecrutementAdmin/{id}','AdminController@getRecrutement');


Route::post('addtocart','EntrepriseController@add_to_cart');
Route::post('deletefromcart','EntrepriseController@delete_from_cart');


Route::post('/editDispoIngs', 'EntrepriseController@editDispoIngs');

Route::get('/getRecrutementIngenieur/{id}', 'CvController@getRecrutement');

Route::post('edittarif', 'CvController@edittarif');


Route::post('setDateEntretien','EntrepriseController@set_date_entretien');


Route::get('partners', 'AdminController@getPartners');

Route::post('makeIngAvailable', 'AdminController@make_Ing_Available');

Route::post('sendRequestIngs', 'EntrepriseController@send_Request_Ings');

Route::post('updatepassword', 'CvController@update_password');


Route::get('/test', 'TestController@index');