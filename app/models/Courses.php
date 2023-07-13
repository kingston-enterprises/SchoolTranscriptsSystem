<?php
/**
 * @category models
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kingstonenterprises\app\models;

use kingston\icarus\DbModel;

/**
 * Courses class used to represent courses entities in the system
 * mainly used to interact with the courses table in the database
 * 
 * @extends \kingston\icarus\DbModel
 */
class Courses extends DbModel
{
    /** @var integer id */
    public int $id = 0;

    /** @var string title */
    public string $title = '';

    /** @var string code */
    public string $code = '';

     /** @var integer instructor */
     public int $instructor = 0;

    public function __construct()
    {
        $this->setAttributes(
            ['title', 'code', 'instructor']
        );
        // form submission rules
        $this->setRules(
            [
                'title' => [self::RULE_REQUIRED],
                'code' => [self::RULE_REQUIRED],
                'instructor' => [self::RULE_REQUIRED]
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
        return 'courses';
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

    /**
     * return user display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->code . ' ' . $this->title;
    }
}
