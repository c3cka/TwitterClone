<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class PostsMigration_100
 */
class PostsMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('posts', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'users_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'title',
                        [
                            'type' => Column::TYPE_TEXT,
                            'size' => 1,
                            'after' => 'users_id'
                        ]
                    ),
                    new Column(
                        'body',
                        [
                            'type' => Column::TYPE_TEXT,
                            'size' => 1,
                            'after' => 'title'
                        ]
                    ),
                    new Column(
                        'excerpt',
                        [
                            'type' => Column::TYPE_TEXT,
                            'size' => 1,
                            'after' => 'body'
                        ]
                    ),
                    new Column(
                        'published',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'size' => 1,
                            'after' => 'excerpt'
                        ]
                    ),
                    new Column(
                        'updated',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'size' => 1,
                            'after' => 'published'
                        ]
                    ),
                    new Column(
                        'pinged',
                        [
                            'type' => Column::TYPE_TEXT,
                            'size' => 1,
                            'after' => 'updated'
                        ]
                    ),
                    new Column(
                        'to_ping',
                        [
                            'type' => Column::TYPE_TEXT,
                            'size' => 1,
                            'after' => 'pinged'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('fk_posts_users', ['users_id'], null)
                ],
                'references' => [
                    new Reference(
                        'fk_posts_users',
                        [
                            'referencedTable' => 'users',
                            'columns' => ['users_id'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'NO ACTION',
                            'onDelete' => 'NO ACTION'
                        ]
                    )
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '1',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
