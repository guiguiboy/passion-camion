<?php
/**
 * Created by PhpStorm.
 * User: guigui
 * Date: 11/03/2018
 * Time: 14:47
 */

namespace AppBundle\Services\Twitter\Tweet;

class Request
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $medias;

    public function __construct(string $status, int $medias)
    {
        $this->status = $status;
        $this->medias = $medias;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMedias()
    {
        return $this->medias;
    }
}
