<?php

/**
 * @category controllers
 * @author kingston-5 <qhawe@kingston-enterprises.net>
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kingstonenterprises\app\controllers;

use kingston\icarus\Application;
use kingston\icarus\Controller;
use kingston\icarus\Request;
use kingston\icarus\helpers\Collection;
use kingstonenterprises\app\models\Permission;
use kingstonenterprises\app\models\Role;
use kingstonenterprises\app\models\User;

/**
 * controls the the sites users views
 *
 * @extends \kingston\icarus\Controller
 */
class UsersController extends Controller
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

        $userModel = new User();
        $permissionModel = new Permission();
        $roleModel = new Role();
        $users = new Collection($userModel->getAll());
        $roles = new Collection($roleModel->getAll());

        foreach ($users->getIterator() as $key => $user) {
            $permission = $permissionModel->findOne(['id' => $user->id]);
            $user->role = $roleModel->findOne(['id' => $permission->role_id])->title;

        }


        return $this->render('users/index', [
            'title' => 'Dashboard',
            'users' => $users,
            'roles' => $roles,

        ]);
    }

    // public function create(Request $request) : string
    // {
    //     if (Application::isGuest()) {
    //         Application::$app->session->setFlash('warning', 'You need To Login first');
    //         Application::$app->response->redirect('/auth/login');
    //     }

    //     $userModel = new Users();

    //     if ($request->getMethod() === 'post') {
    //         $anModel->loadData($request->getBody());

    //         $anModel->author = Application::$app->session->get('user');
    //         $anModel->created_at = date("Y-m-d H:i:s");
            
    //     // var_dump($anModel);exit();

    //         if ($anModel->validate() && $anModel->save()) {
                
    //             Application::$app->session->setFlash('success', 'Your announcement Has been posted');
    //             Application::$app->response->redirect('/announcements');
    //             return 'Show success page';
    //         }

    //     }
        
    //     return $this->render('announcements/create', [
    //     	'title' => 'Register',
    //         'model' => $anModel
    //     ]);
    // }

    public function update(Request $request) : string
    {
        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        $userModel = new User();
        $permissionModel = new Permission();
        $roleModel = new Role();

        $user = $userModel->findOne(['id' => $request->getRouteParam('id')]);

        if ($request->getMethod() === 'post') {
            $userPermissions = $permissionModel->findOne(['user_id' => $user->id]);
            $newRole = $roleModel->findOne(['title' => $request->getBody()['role']]);
            $userPermissions->role_id = $newRole->id;
            // \var_dump($userPermissions->role_id);exit();
            // $anModel->updated_at = date("Y-m-d H:i:s");            
        // var_dump($anModel);exit();

            if ($userPermissions->update($request->getRouteParam('id'))) {
                
                Application::$app->session->setFlash('success', 'Your user Has been updated');
                Application::$app->response->redirect('/users');
                return 'Show success page';
            }

        }

        $userModel = new User();
        $permissionModel = new Permission();
        $roleModel = new Role();
        $users = new Collection($userModel->getAll());
        $roles = new Collection($roleModel->getAll());

        foreach ($users->getIterator() as $key => $user) {
            $permission = $permissionModel->findOne(['id' => $user->id]);
            $user->role = $roleModel->findOne(['id' => $permission->id])->title;
        }
        
        return $this->render('users/index', [
        	'title' => 'Register',
            'model' => $user,
            'users' => $users,
            'roles' => $roles,
        ]);

        
    }


}