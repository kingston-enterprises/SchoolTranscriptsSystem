<?php
/** 
 * This file is the root file for the application
 * it starts the application lifecycle and routes all requests to the appropriate controller
 *
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use kingston\icarus\Application;


use kingstonenterprises\app\controllers\SiteController;
use kingstonenterprises\app\controllers\AuthController;
use kingstonenterprises\app\controllers\DashboardController;
use kingstonenterprises\app\controllers\AnnouncementsController;
use kingstonenterprises\app\controllers\CoursesController;
use kingstonenterprises\app\controllers\UsersController;
use kingstonenterprises\app\controllers\RegistrationController;
use kingstonenterprises\app\controllers\GradesController;

use kingstonenterprises\app\models\Visitor;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
    'migrations' => '/../migrations/'
];

$app = new Application(dirname(__DIR__), $config);

$app->on(Application::EVENT_BEFORE_REQUEST, function () {
    $visitor = new Visitor();

    if (!$visitor->findOne(['ip' => $visitor->ip])) {
        $visitor->ip = $visitor->ip;
        $visitor->save();
    }

    $visitor = $visitor->findOne(['ip' => $visitor->ip]);
    Application::$app->session->set('visitorId', $visitor->id);
});


$app->triggerEvent(Application::EVENT_AFTER_REQUEST);
// URL structure : /controller/method/{params}

// Site controller
$app->router->get('/', [SiteController::class, 'home']);
$app->router->post('/', [SiteController::class, 'home']);

// Auth controller
$app->router->get('/auth/register', [AuthController::class, 'register']);
$app->router->post('/auth/register', [AuthController::class, 'register']);
$app->router->get('/auth/login', [AuthController::class, 'login']);
$app->router->post('/auth/login', [AuthController::class, 'login']);
$app->router->get('/auth/logout', [AuthController::class, 'logout']);


// Dashboard controller
$app->router->get('/dashboard', [DashboardController::class, 'index']);
$app->router->get('/update/profile', [DashboardController::class, 'updateProfile']);
$app->router->post('/update/profile', [DashboardController::class, 'updateProfile']);

// Announcements Controller
$app->router->get('/announcements', [AnnouncementsController::class, 'index']);
$app->router->get('/announcements/create/', [AnnouncementsController::class, 'create']);
$app->router->post('/announcements/create/', [AnnouncementsController::class, 'create']);
$app->router->get('/announcements/update/{id}/', [AnnouncementsController::class, 'update']);
$app->router->post('/announcements/update/{id}/', [AnnouncementsController::class, 'update']);
$app->router->post('/announcements/delete/{id}/', [AnnouncementsController::class, 'delete']);

// Announcements Controller
$app->router->get('/courses', [CoursesController::class, 'index']);
$app->router->get('/courses/create/', [CoursesController::class, 'create']);
$app->router->post('/courses/create/', [CoursesController::class, 'create']);
$app->router->get('/courses/update/{id}/', [CoursesController::class, 'update']);
$app->router->post('/courses/update/{id}/', [CoursesController::class, 'update']);
$app->router->post('/courses/delete/{id}/', [CoursesController::class, 'delete']);

// Users Controller
$app->router->get('/users', [UsersController::class, 'index']);
$app->router->post('/users/update/{id}/', [UsersController::class, 'update']);

// Registration Controller
$app->router->get('/registration', [RegistrationController::class, 'index']);
$app->router->get('/registration/create/', [RegistrationController::class, 'create']);
$app->router->post('/registration/create/', [RegistrationController::class, 'create']);

// Grades Controller
$app->router->get('/grades', [GradesController::class, 'index']);
$app->router->get('/grades/create/{id}', [GradesController::class, 'create']);
$app->router->post('/grades/create/{id}', [GradesController::class, 'create']);
$app->router->get('/grades/view/', [GradesController::class, 'view']);


$app->run();
