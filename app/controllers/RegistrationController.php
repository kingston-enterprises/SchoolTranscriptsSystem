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
use kingstonenterprises\app\models\Registration;
use kingstonenterprises\app\models\User;

/**
 * controls the the sites registration views
 *
 * @extends \kingston\icarus\Controller
 */
class RegistrationController extends Controller
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

        $registrationModel = new Registration();
        $userModel = new User();
        $courseModel = new Courses();

        $registration = new Collection($registrationModel->getAll());
        foreach ($registration->getIterator() as $key => $reg) {
            $reg->course = $courseModel->findOne(['id' => $reg->course_id]);
            //NOTE: leader is a temp var name for instuctor
            $reg->course->leader = $userModel->findOne(['id' => $reg->course->instructor]);

        
        }

        return $this->render('registration/index', [
            'title' => 'Dashboard',
            'registration' => $registration,
            'userModel' => $userModel,
            'courseModel' => $courseModel
        ]);
    }

    public function create(Request $request): string
    {
        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }
        $registrationModel = new Registration();
        $courseModel = new Courses();



        if ($request->getMethod() === 'post') {
            $courses = $request->getBody();
            foreach ($courses as $key => $course) {
                $course = $courseModel->findOne(['id' => $key]);

                $registrationModel->student_id = Application::$app->session->get('user');

                $registrationModel->course_id = $course->id;
                if($registrationModel->findOne(['course_id' => $course->id])->student_id != Application::$app->session->get('user')){
                    $registrationModel->validate();
                    $registrationModel->save();
                }
            }

            Application::$app->session->setFlash('success', 'registration complete');
            Application::$app->response->redirect('/registration');
            return 'Show success page';
        }

        $courses = new Collection($courseModel->getAll());

        return $this->render('registration/create', [
            'title' => 'Register',
            'model' => $registrationModel,
            'courses' => $courses
        ]);
    }
}
