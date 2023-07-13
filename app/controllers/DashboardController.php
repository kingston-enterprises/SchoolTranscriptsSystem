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
use kingstonenterprises\app\models\Announcements;
use kingstonenterprises\app\models\User;
use kingstonenterprises\app\models\Visitor;
use kingstonenterprises\app\models\Role;
use kingstonenterprises\app\models\Permission;
use kingstonenterprises\app\models\Courses;

/**
 * controls the the sites dashboard views
 *
 * @extends \kingston\icarus\Controller
 */
class DashboardController extends Controller
{

    /**
     * collect stats and render dashboard
     * 
     * @return string
     */
    public function index()
    {

        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        $visitorModel = new Visitor;
        $announcementsModel = new Announcements;
        $userModel = new User;
        $roleModel = new Role;
        $coursesModel = new Courses;
        $permissionModel = new Permission;

        $visitors = new Collection($visitorModel->getAll());
        $announcements = new Collection($announcementsModel->getAll());
        $courses = new Collection($coursesModel->getAll());
        $users = new Collection($userModel->getAll());


        $user = $userModel->findOne(['id' => Application::$app->session->get('user')]);
        $user->joined = date_create($user->joined)->format("D M j Y");

        $perm = $permissionModel->findOne(['user_id' => Application::$app->session->get('user')]);
        $user->role = $roleModel->findOne(['id' => $perm->role_id]);

        return $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'visitors' => $visitors->count(),
            'announcements' => $announcements->count(),
            'user' => $user,
            'users' => $users->count(),
            'courses' => $courses->count()

        ]);
    }

    /**
     * render user update profile page Or if user submitted form, check 
     * if user details are valid and update user details
     *
     * @param Request $request
     * @return string
     */
    public function updateProfile(Request $request)
    {
        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        $user = new User;
        $user = $user->findOne(['id' => Application::$app->session->get('user')]);

        if ($request->getMethod() === 'post') {
            $user->loadData($request->getBody());
            if(!empty($user->password)){
                $user->password = password_hash($user->password, PASSWORD_DEFAULT);

            }

            if ($user->update($user->id)) {
                Application::$app->session->setFlash('success', 'Your Details have Been Updated');
                Application::$app->response->redirect('/dashboard');
                return 'Show success page';
            } else {
                echo "val failed";
            }
        }

        return $this->render('dashboard/updateProfile', [
            'title' => 'Update Profile',
            'user' => $user,
            'model' => new User
        ]);
    }
}
