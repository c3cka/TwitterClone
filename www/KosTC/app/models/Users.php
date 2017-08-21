<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=16, nullable=false)
     */
    public $username;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=false)
     */
    public $email;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $updated_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $role;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        $validator->add(
            'email',
            new Validation\Validator\Uniqueness(
                [
                    'message' => 'Email already in use!'
                ]
            )
        );

        $validator->add(
            'password',
            new StringLength(
                [
                    'min'   => 8,
                    'messageMinimum' => 'Password must be at least 8 characters!',
                    'max'   => 20,
                    'messageMaximum' => 'Password must be less than 20 characters',
                ])
        );
        return $this->validate($validator);
    }

    public function afterValidationOnCreate(){

        // Always hash the password on update
        $this->password = sha1($this->password);
}

    public function afterValidationOnUpdate(){

        // If there has been a change in the password, re-hash it
        if($this->hasChanged('password')){
            $this->password = sha1($this->password);
    }

    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {

        $this->addBehavior(new Timestampable([
                'beforeCreate' => [
                    'field' => 'created_at',
                    'format' => 'Y-m-d H:i:s'
                ]]
        ));
        $this->addBehavior(new Timestampable([
                'beforeUpdate' => [
                    'field' => 'updated_at',
                    'format' => 'Y-m-d H:i:s'
                ]]
        ));

        $this->setSchema("phalconblog");
        $this->hasMany('id', 'Posts', 'users_id', ['alias' => 'Posts']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
