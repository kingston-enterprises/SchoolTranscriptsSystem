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
use kingstonenterprises\app\models\Courses;
use kingstonenterprises\app\models\Grades;
use kingstonenterprises\app\models\Registration;
use kingstonenterprises\app\models\User;

/**
 * controls the the sites grades views
 *
 * @extends \kingston\icarus\Controller
 */
class GradesController extends Controller
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

        $courseModel = new Courses();

        $allCourses = new Collection($courseModel->getAll());
        $courses = array();
        foreach ($allCourses as $course) {
            if ($course->instructor ==  Application::$app->session->get('user')) {
                array_push($courses, $course);
            }
        }

        $courses = new Collection($courses);

        return $this->render('grades/index', [
            'title' => 'Dashboard',
            'courses' => $courses
        ]);
    }

    public function create(Request $request): string
    {
        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }

        $gradesModel = new Grades();
        $registrationModel = new Registration();
        $courseModel = new Courses();
        $userModel = new User();

        $course = $courseModel->findOne(['id' => $request->getRouteParam('id')]);
        $students = new Collection($registrationModel->findAll(['course_id' => $course->id]));
        // var_dump($students);exit();/
        foreach ($students->getIterator() as $student) {
            $user = $userModel->findOne(['id' => $student->student_id]);
            $student->name = $user->getDisplayName();
            $student->student_id = $user->id_number;
        }


        if ($request->getMethod() === 'post') {
            // \var_dump($_POST);exit();
            $grades = $request->getBody();

            foreach ($grades as $key => $grade) {
                $gradesModel = new Grades();
                $gradesModel->student_id = (int)$key;
                $gradesModel->course_id = $course->id;
                $gradesModel->grade = $grade;

                // \var_dump($gradesModel->save());exit();
                $gradesModel->save();
            }

            Application::$app->session->setFlash('success', 'student grades inserted');
            Application::$app->response->redirect('/grades');
        }


        return $this->render('grades/create', [
            'title' => 'Register',
            'model' => $gradesModel,
            'students' => $students,
            'course' => $course
        ]);
    }

    public function view()
    {
        if (Application::isGuest()) {
            Application::$app->session->setFlash('warning', 'You need To Login first');
            Application::$app->response->redirect('/auth/login');
        }



        $gradesModel = new Grades();
        $registrationModel = new Registration();
        $courseModel = new Courses();
        $userModel = new User();

        $user = $userModel->findOne(['id' => Application::$app->session->get('user')]);
        $user->grades = $gradesModel->findAll(['student_id' => $user->id_number]);
        foreach ($user->grades as $grade) {
            $course = $courseModel->findOne(['id' => $grade->course_id]);
            $grade->course_title = $course->title;
            $grade->course_code = $course->code;

            // \var_dump($grade);
        }

        // \var_dump($user->grades);
        // exit();
        // $students = new Collection($registrationModel->findAll(['course_id' => $course->id]));

        // foreach ($students->getIterator() as $key => $student) {
        //     $user = $userModel->findOne(['id' => $student->id]);
        //     if ($user != false) {
        //         $student->name = $user->getDisplayName();
        //         $student->student_id = $user->id_number;
        //     }
        // }

        $courses = new Collection($courseModel->getAll());

        return $this->render('grades/view', [
            'title' => 'Register',
            'user' => $user
        ]);
    }
}
