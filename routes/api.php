<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => [
        'auth:api',
    ],
], function () {
    Route::apiResources([
        'audiences' => 'API\AudienceController',
        'buildings' => 'API\BuildingController',
        'courses' => 'API\CourseController',
        'configurations' => 'API\ConfigurationController',
        'degrees' => 'API\DegreeController',
        'departments' => 'API\DepartmentController',
        'faculties' => 'API\FacultyController',
        'files' => 'API\FileController',
        'groups' => 'API\GroupController',
        'positions' => 'API\PositionController',
        'roles' => 'API\RoleController',
        'specialities' => 'API\SpecialityController',
        'students' => 'API\StudentController',
        'teachers' => 'API\TeacherController',
        'timetables' => 'API\TimetableController',
        'users' => 'API\UserController',
    ]);
    Route::get('timetables/group/{id}', 'API\TimetableController@showByGroupId');
    Route::get('timetables/teacher/{id}', 'API\TimetableController@showByTeacherId');
    Route::get('user', 'API\UserController@me');
});
