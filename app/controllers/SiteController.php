<?php

/** 
 * controls the sites functions that do not require special access or permissions
 *
 * @category controllers
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kingstonenterprises\app\controllers;

use kingstonenterprises\app\models\Announcements;
use kingston\icarus\helpers\Collection;
use kingston\icarus\Controller;
use kingstonenterprises\app\models\User;

/**
 * controls the sites functions that do not require special 
 * access or permissions wjich mainly include rendering the homepage.
 * 
 * @extends \kingston\icarus\Controller
 */
class SiteController extends Controller
{

    /**
     * render Home view
     *
     * @return string
     */
    public function home()
    {

        $anModel = new Announcements();
        $announcements = new Collection($anModel->getAll());
        $userModel = new User();

        foreach($announcements->getIterator() as $key => $announcement) {
            $announcement->user = $userModel->findOne(['id' => $announcement->author]);
        }

        return $this->render('home', [
            "title" => 'School Transcripts System',
            'announcements' => $announcements
        ]);
    }
}
