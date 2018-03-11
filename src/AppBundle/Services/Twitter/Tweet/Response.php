<?php
/**
 * Created by PhpStorm.
 * User: guigui
 * Date: 11/03/2018
 * Time: 15:34
 */

namespace AppBundle\Services\Twitter\Tweet;

class Response
{
    protected $id;

    /**
     * Response constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
