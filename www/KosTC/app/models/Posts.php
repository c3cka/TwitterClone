<?php

class Posts extends \Phalcon\Mvc\Model
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
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $users_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $body;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $excerpt;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $published;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $updated;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $pinged;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $to_ping;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalconblog");
        $this->hasMany('id', 'Comments', 'posts_id', ['alias' => 'Comments']);
        $this->hasMany('id', 'PostTags', 'posts_id', ['alias' => 'PostTags']);
        $this->belongsTo('users_id', '\Users', 'id', ['alias' => 'Users']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'posts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts[]|Posts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
