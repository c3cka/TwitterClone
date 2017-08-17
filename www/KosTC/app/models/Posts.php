<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;

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

        $this->addBehavior(new Timestampable([
                'beforeCreate' => [
                    'field' => 'published',
                    'format' => 'Y-m-d H:i:s'
                ]]
        ));
        $this->addBehavior(new Timestampable([
                'beforeUpdate' => [
                    'field' => 'updated',
                    'format' => 'Y-m-d H:i:s'
                ]]
        ));

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


    public function addTags($tags)
    {
        foreach ($tags as $t) {
            $t = trim($t);
            $tag = Tags::findFirst(["tag = '$t'"]);
            if (!$tag) {
                $tag = new Tags();
                $tag->tag = $t;
                $tag->save();
            }
            $postTag = PostTags::findFirst([
                    "conditions" => "$this->id = ?1 AND tags_id = ?2",
                    "bind" => [
                        1 => $this->id,
                        2 => $tag->id
                    ]
                ]);
            if (!$postTag) {
                $postTag = new PostTags();
                $postTag->posts_id = $this->id;
                $postTag->tags_id = $tag->id;
                $postTag->save();
            }
            unset($tag);
            unset($postTag);
        }
    }
}
