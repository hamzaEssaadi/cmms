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

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', 'DashboardController@index')->middleware('auth');
Route::get('/test', function () {
    return  public_path('/');
   return view('calendar');
}
)->middleware('auth');
Route::post('/test',function (\Illuminate\Http\Request $request)
{

})->middleware('auth');

Route::get('/events',function(){
$events=\App\Event::select('id','title','start','end')->get();
return ($events);
});

Route::resource('employees', 'EmployeesController')->middleware('auth');
Route::get('employees-deleted','EmployeesController@deleted');
Route::get('employees/{id}/restore','EmployeesController@restore');
Route::resource('jobpositions', 'JobController')->middleware('auth');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//trainings
Route::get('trainings/{employee}', 'TrainingController@create')->middleware('auth');
Route::post('trainings/{employee}', 'TrainingController@store')->middleware('auth');
Route::get('trainings/{training}/edit', 'TrainingController@edit')->middleware('auth');
Route::put('trainings/{training}', 'TrainingController@update')->middleware('auth');
Route::delete('trainings/{training}', 'TrainingController@destroy')->middleware('auth');
//salary
Route::get('salaries/{employee}', 'SalaryController@create')->middleware('auth');
Route::post('salaries/{employee}', 'SalaryController@store')->middleware('auth');
Route::get('salaries/{salary}/edit', 'SalaryController@edit')->middleware('auth');
Route::put('salaries/{salary}', 'SalaryController@update')->middleware('auth');
Route::delete('salaries/{salary}', 'SalaryController@destroy')->middleware('auth');
//exceptions
Route::get('exceptions/{employee}', 'WorkexceptionController@create')->middleware('auth');
Route::post('exceptions/{employee}', 'WorkexceptionController@store')->middleware('auth');
Route::get('exceptions/{exception}/edit', 'WorkexceptionController@edit')->middleware('auth');
Route::put('exceptions/{exception}', 'WorkexceptionController@update')->middleware('auth');
Route::delete('exceptions/{exception}', 'WorkexceptionController@destroy')->middleware('auth');

//providers
Route::get('providers/{type}', 'ProviderController@index')->middleware('auth');
Route::get('providers/{type}/create', 'ProviderController@create')->middleware('auth');
Route::post('providers/{type}', 'ProviderController@store')->middleware('auth');
Route::get('providers/{provider}/edit', 'ProviderController@edit')->middleware('auth');
Route::put('providers/{provider}', 'ProviderController@update')->middleware('auth');

//articles
Route::resource('articles', 'ArticlesController')->middleware('auth');
Route::post('articles/{article}/suppliers', 'ArticlesController@add_supplier')->middleware('auth');
Route::delete('articles/{suppliers_articles}/supplier', 'ArticlesController@destroy_supplier')->middleware('auth');
Route::post('articles/{article}/replace', 'ArticlesController@replace')->middleware('auth');
Route::delete('articles/replace/{replacement_article}', 'ArticlesController@remove_replace')->middleware('auth');

//stocks
Route::get('stocks/{article}', 'StocksController@create')->middleware('auth');
Route::post('stocks/{article}', 'StocksController@store')->middleware('auth');
Route::delete('stocks/{stock}', 'StocksController@destroy')->middleware('auth');
Route::put('stocks/{stock}', 'StocksController@update')->name('edit.stock');

//locations
Route::resource('locations', 'LocationsController');

//show more details

Route::get('articles/{article}/more', 'ArticlesController@showmore')->middleware('auth');
// costs
Route::get('articles/{article}/cost', 'ArticlesController@createCost')->middleware('auth');
Route::post('articles/{article}/cost', 'ArticlesController@storeCost')->middleware('auth');
Route::delete('articles/{cost}/delete', 'ArticlesController@destroyCost')->middleware('auth');
Route::put('articles/{cost}/cost', 'ArticlesController@update_cost')->name('cost.edit');
//end cost
//purposes
Route::post('articles/{article}/purposes', 'ArticlesController@storePurposes')->middleware('auth');
Route::delete('articles/{purpose}/delete/purpose', 'ArticlesController@destroyPurpose')->middleware('auth');

//articles commands
Route::get('articles/{article}/commands', 'CommandsController@index')->name('commands');
Route::get('articles/{article}/commands/create', 'CommandsController@create')->name('commands.create');
Route::post('articles/{article}/commands', 'CommandsController@store')->name('commands.store');
Route::get('articles/{stock}/qte', 'CommandsController@qteStock')->name('commands.qntStock');
Route::delete('articles/commands/{command}','CommandsController@cancelCommand');
Route::get('articles/commands/all','CommandsController@all')->name('commands.all');

//disfunction causes
Route::resource('disfunctions','DisfunctionsController');
//departments
Route::resource('departments','DepartmentController');

//equipments types
Route::resource('equipment-types','EquipmentTypesController');
Route::resource('equipments','EquipmentController');
 //spares
Route::post('equipments/{equipment}/create-spare','EquipmentController@createSpare')->name('spares.create');
Route::delete('spares/{id}/delete','EquipmentController@destroySpare');
// stocks article
Route::get('stocks/article/{id}','EquipmentController@stocksArticle');

//payments equipment
Route::get('equipments/{equipment}/payments/create','PaymentController@create')->name('payments.store');
Route::post('equipments/{equipment}/payments/store','PaymentController@store')->name('payments.store');
Route::delete('payments/{payment}','PaymentController@destroy');

//technical drawing
Route::get('equipment/{equipment}/technical-drawing','DrawingController@index')->name('technical-drawing');
Route::get('equipment/{equipment}/technical-drawing/create','DrawingController@create')->name('technical-drawing-create');
Route::post('equipment/{equipment}/technical-drawing/store','DrawingController@store')->name('technical-drawing-store');
Route::get('equipment/{equipment}/technical-drawing/show','DrawingController@show')->name('technical-drawing-show');
Route::delete('drawings/{drawing}/delete','DrawingController@destroy');

//work order type
Route::resource('/work-order-types','WorkOrderTypeController');
//work order
Route::resource('/work-orders','WorkOrderController');

    //workers
Route::post('/add-worker/{workOrder}','WorkOrderController@addWorker')->name('add-worker');
Route::delete('/detach-worker/{worker}','WorkOrderController@detachWorker');
    //equipments
Route::post('/add-equipment/{workOrder}','WorkOrderController@addEquipment')->name('add-equipment');
Route::delete('/detach-equipment/{WorkEquipment}','WorkOrderController@detachEquipment');
    //articles
Route::post('/add-article/{workOrder}','WorkOrderController@addArticle')->name('add-article');
Route::delete('/detach-article/{workArticle}','WorkOrderController@detachArticle');
    //validate
Route::get('/work-order-validate/{worker}','WorkOrderController@validateOrder')->name('validate.order');

//users
Route::resource('/users','UserController');
//update profile
Route::get('/users/{user}/profile','UserController@profileEdit')->name('profile.edit');
Route::put('/users/{user}/profile','UserController@updateProfile')->name('profile.update');

//intervention requests
Route::resource('/interventions-requests','InterventionController');
    //work order
Route::get('/interventions-requests/{interventionRequest}/create-order','InterventionController@createOrder')->name('request.order.create');
Route::post('/interventions-requests/{interventionRequest}/store-order','InterventionController@storeOrder')->name('request.order.store');
Route::get('/interventions-requests/{workOrder}/show-order','InterventionController@showOrder')->name('request.show.order');
    //end orders
//validation
Route::get('/interventions-requests/{interventionRequest}/validate','InterventionController@validationForm')->name('request.validate');
Route::post('/interventions-requests/{interventionRequest}/validate','InterventionController@validationStore')->name('request.validate.store');
Route::put('/interventions-requests/{interventionRequest}/cancel-validation','InterventionController@cancelValidation')
    ->name('request.cancel.validation');
//edit
Route::put('/interventions-requests/{interventionRequest}/update-info','InterventionController@updateInfo')
    ->name('request.update.info');
Route::put('/interventions-requests/{interventionRequest}/update-validation','InterventionController@updateValidation')
    ->name('request.update.validation');

// intervention preventive
Route::resource('/preventive-interventions','PreventiveController');
//validation
Route::get('/preventive-intervention/{preventiveIntervention}/validation','PreventiveController@validation')->name('validate.preventive');
Route::put('/preventive-intervention/{preventiveIntervention}/validation-cancel','PreventiveController@validation');
Route::delete('/preventive-intervention/{preventiveIntervention}','PreventiveController@destroy');
//calendar
Route::get('/preventive-intervention/calendar','PreventiveController@calendar');



//ajax
Route::get('articles-ajax','AjaxController@articles')->name('articles.ajax');
Route::get('commands-ajax','AjaxController@commands')->name('commands.ajax');
Route::get('interventions-ajax','AjaxController@requests')->name('requests.ajax');
Route::get('orders-ajax','AjaxController@orders')->name('orders.ajax');
Route::get('preventive-ajax','AjaxController@preventive')->name('preventive.ajax');

//graph
    //graph by machine
Route::get('intervention-request/{id}/year/{year}','ChartsController@chartBymMachine')->name('graph.by.machine');
    //graph by all
Route::get('intervention-request/all/{year}','ChartsController@chartByAll')->name('graph.by.all');
    //commands
Route::get('commands-percentage','ChartsController@commandPercentage');
    //supplier graph
Route::get('suppliers-graph','ChartsController@suppliers');
    //manufacturers graph
Route::get('manufacturers-graph','ChartsController@manufacturers');
    //job by employees
Route::get('employees-job','ChartsController@jobCount');

//projects
Route::get('/projects','ProjectController@index');
Route::get('/projects-details','ProjectController@details');
    //show task
Route::get('/projects-details/{task}','ProjectController@task');
    //add participant to task
Route::post('/task-add/{task}','ProjectController@addParticipant')->name('add.participant');
Route::delete('/task-detach/{employeeTask}','ProjectController@detachParticipant')->name('detach.participant');

//my tasks
Route::get('my-tasks','MytaskController@index')->name('myTasks');
    //validation
Route::get('my-tasks/{employee_task}','MytaskController@validation')->name('validation.myTask');

//reports
Route::resource('/reports','ReportController');


