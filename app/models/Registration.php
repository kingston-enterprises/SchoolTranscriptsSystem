<?php

/**
 * @category models
 * @author kingston-5 <qhawe@kingston-enterprises.net>
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kingstonenterprises\app\models;

use kingston\icarus\DbModel;

/**
 *  * Permission class used to represent user permissions in the system
 * 
 * @extends \kingston\icarus\DbModel
 */
class Registration extends DbModel
{
    /** @var integer id */
    public int $id = 0;

    /** @var integer student_id */
    public int $student_id = 0;

    /** @var integer course_id */
    public int $course_id = 0;

    public function __construct()
    {
        $this->setAttributes(
            ['student_id', 'course_id']
        );
        // form submission rules
        $this->setRules(
            [
                'course_id' => [self::RULE_REQUIRED]
            ]
        );
    }

    /**
     * return database table name
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'registration';
    }

 
    /**
     * save record to database
     * we need to hash the user password 
     * before we save the record to the database
     *
     * @return boolean
     */
    public function save(): bool
    {
        return parent::save();
    }

    // methods to get attributes    
    /** 
     * return record Id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * return user display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->student_id . ':' . $this->course_id;
    }
}
