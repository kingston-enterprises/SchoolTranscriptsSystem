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

/**
 * controls the the sites announcements views
 *
 * @extends \kingston\icarus\Controller
 */
class AnnouncementsController extends Controller
{

    /**
     * collect and render announcements
     * 
     * @return string
     */
    public function index()
    {

        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an admin
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }

        $anModel = new Announcements();
        $announcements = new Collection($anModel->getAll());

        return $this->render('announcements/index', [
            'title' => 'Dashboard',
            'announcements' => $announcements

        ]);
    }

    public function create(Request $request) : string
    {
        if (Application::isGuest()) { // if user is not logged in
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an admin
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }

        $anModel = new Announcements();

        if ($request->getMethod() === 'post') {
            $anModel->loadData($request->getBody());

            $anModel->author = Application::$app->session->get('user');
            $anModel->created_at = date("Y-m-d H:i:s");

            if ($anModel->validate() && $anModel->save()) {
                
                Application::$app->session->setFlash('success', 'Your announcement Has been posted');
                Application::$app->response->redirect('/announcements');
                return 'Show success page';
            }

        }
        
        return $this->render('announcements/create', [
        	'title' => 'Register',
            'model' => $anModel
        ]);
    }

    public function update(Request $request) : string
    {
        if (Application::isGuest()) { // if user is not logged in
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an admin
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }

        $anModel = new Announcements();

        $anModel = $anModel->findOne(['id' => $request->getRouteParam('id')]);

        if ($request->getMethod() === 'post') {
            $anModel->loadData($request->getBody());
            $anModel->updated_at = date("Y-m-d H:i:s");

            if ($anModel->validate() && $anModel->update($request->getRouteParam('id'))) {
                
                Application::$app->session->setFlash('success', 'Your announcement Has been updated');
                Application::$app->response->redirect('/announcements');
                return 'Show success page';
            }

        }
        
        return $this->render('announcements/update', [
        	'title' => 'Register',
            'model' => $anModel
        ]);

        
    }

    public function delete(Request $request)
    {

        if (Application::isGuest()) { // if user is not logged in
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        if (Application::$app->session->get('role') != 1) { // if user is not an admin
            Application::$app->session->setFlash('error', 'Higher permissions are necessary');
            Application::$app->response->redirect('/dashboard');
        }
        
        $anModel = new Announcements();

        $ann = $anModel->findOne(['id' => $request->getRouteParam('id')]);

        if ($request->getMethod() === 'post') {

            if ($anModel->delete($ann->id)) {

                Application::$app->session->setFlash('success', 'catergory deleted');
                Application::$app->response->redirect('/announcements');
                return 'Show success page';
            }
        }

        $ann = new Collection($anModel->getAll());

        return $this->render('announcements/index', [
            'title' => 'Dashboard',
            'announcements' => $ann
        ]);
    }
}