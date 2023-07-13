<?php

/**
 * @category controllers
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kingstonenterprises\app\controllers;

use kingston\icarus\Application;
use kingston\icarus\Controller;
use kingston\icarus\Request;
use kingston\icarus\helpers\Collection;

use kingstonenterprises\app\models\Courses;
use kingstonenterprises\app\models\Permission;
use kingstonenterprises\app\models\User;

/**
 * controls the the sites dashboard views
 *
 * @extends \kingston\icarus\Controller
 */
class CoursesController extends Controller
{

    /**
     * collect stats and render dashboard
     * 
     * @return string
     */
    public function index()
    {

        if (Application::isGuest()) { // if user is not logged in
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an teacher
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }

        $coursesModel = new Courses();
        $usersModel = new User();

        $courses = new Collection($coursesModel->getAll());
        foreach ($courses->getIterator() as $course) {
            $course->instructor = $usersModel->findOne(['id' => $course->instructor]);
        }


        return $this->render('courses/index', [
            'title' => 'Dashboard',
            'courses' => $courses

        ]);
    }

    public function create(Request $request): string
    {
        if (Application::isGuest()) { // if user is not logged in
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an admin
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }

        $coursesModel = new Courses();
        $permisionModel = new Permission();
        $usersModel = new User();

        $users = $usersModel->getAll();
        $users = new Collection($users);
        $permision = $permisionModel->getAll();
        $permision = new Collection($permision);

        // get users with teacher permissions
        $instructors = array();
        foreach ($users->getIterator() as $user) {
            foreach ($permision->getIterator() as $perm) {
                if ($user->id == $perm->user_id && $perm->role_id == 2) {
                    \array_push($instructors, $user);
                }
            }
        }

        $instructors = new Collection($instructors);

        if ($request->getMethod() === 'post') {
            $coursesModel->loadData($request->getBody());

            if ($coursesModel->validate() && $coursesModel->save()) {

                Application::$app->session->setFlash('success', 'Your course Has been posted');
                Application::$app->response->redirect('/courses');
                return 'Show success page';
            }
        }

        return $this->render('courses/create', [
            'title' => 'Register',
            'model' => $coursesModel,
            'instructors' => $instructors
        ]);
    }

    public function update(Request $request): string
    {
        if (Application::isGuest()) { // if user is not logged in
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an teacher
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }

        $coursesModel = new Courses();
        $usersModel = new User();


        $course = $coursesModel->findOne(['id' => $request->getRouteParam('id')]);

        $coursesModel = new Courses();
        $permisionModel = new Permission();
        $usersModel = new User();

        $users = $usersModel->getAll();
        $users = new Collection($users);
        $permision = $permisionModel->getAll();
        $permision = new Collection($permision);

        // get users with teacher permissions
        $instructors = array();
        foreach ($users->getIterator() as $user) {
            foreach ($permision->getIterator() as $perm) {
                if ($user->id == $perm->user_id && $perm->role_id == 2) {
                    \array_push($instructors, $user);
                }
            }
        }

        $instructors = new Collection($instructors);



        if ($request->getMethod() === 'post') {
            $course->loadData($request->getBody());

            if ($course->validate() && $course->update($request->getRouteParam('id'))) {

                Application::$app->session->setFlash('success', 'Your course Has been updated');
                Application::$app->response->redirect('/courses');
                return 'Show success page';
            }
        }

        return $this->render('courses/update', [
            'title' => 'Register',
            'model' => $coursesModel,
            'instructors' => $instructors
        ]);
    }
}
