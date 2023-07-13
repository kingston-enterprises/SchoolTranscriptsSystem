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
 * User class used to represent user entities in the system
 * mainly used to interact with the users table in the database
 * and also create user registration form
 * 
 * @extends \kingston\icarus\DbModel
 */
class User extends DbModel
{
    /** @var integer id */
    public int $id = 0;

    /** @var integer id_number */
    public int $id_number = 0;

    /** @var string firstname */
    public string $firstname = '';

    /** @var string lastname */
    public string $lastname = '';

    /** @var string email */
    public string $email = '';

    /** @var string password */
    public string $password = '';

    /** @var string password confirmation */
    public string $passwordConfirm = '';

    /** @var string|datetime date joined */
    public string $joined = '';



    public function __construct()
    {
        $this->setAttributes(
            ['firstname', 'lastname', 'id_number', 'email', 'password']
        );
        // form submission rules
        $this->setRules(
            [
                'firstname' => [self::RULE_REQUIRED],
                'lastname' => [self::RULE_REQUIRED],
                'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                    self::RULE_UNIQUE, 'class' => self::class
                ]],
                'id_number' => [self::RULE_REQUIRED, [
                    self::RULE_UNIQUE, 'class' => self::class
                ]],
                'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
                'passwordConfirm' => [[self::RULE_MATCH, 'match' => 'password']]
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
        return 'users';
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
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

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
        return $this->firstname . ' ' . $this->lastname;
    }

     /**
     * check if user has provided valid login details
     * replaces previously used User::login()
     * 
     * @return bool
     */
    public function loginValid() : bool
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User does not exist with this email');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return true;
    }
}
