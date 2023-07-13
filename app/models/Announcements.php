<?php

/**
 * @category models
 * @license For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace kingstonenterprises\app\models;

use kingston\icarus\DbModel;

/**
 * Announcement class used to represent entities in the system
 * mainly used to interact with the database 
 * 
 * @extends \kingston\icarus\DbModel
 */
class Announcements extends DbModel
{
    /** @var integer id */
    public int $id = 0;

    /** @var string title */
    public string $title = '';

    /** @var string body */
    public string $body = '';

    /** @var int author */
    public int $author = 0;

    /** @var datetime date created_at */
    public string $created_at = '';

    /** @var datetime date created_at */
    public string $updated_at = '';


    public function __construct()
    {
        $this->setAttributes(
            ['title', 'body', 'author', 'created_at', 'updated_at']
        );
        // form submission rules
        $this->setRules(
            [
                'title' => [self::RULE_REQUIRED],
                'body' => [self::RULE_REQUIRED]
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
        return 'announcements';
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
        $this->updated_at = date("Y-m-d H:i:s");

        return parent::save();
    }

    /**
     * return user display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->title . ' ' . $this->body;
    }
}
