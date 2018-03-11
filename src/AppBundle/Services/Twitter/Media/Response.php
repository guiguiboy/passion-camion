<?php
/**
 * Created by PhpStorm.
 * User: guigui
 * Date: 11/03/2018
 * Time: 14:39
 */

namespace AppBundle\Services\Twitter\Media;

class Response
{
    /**
     * @var integer
     */
    protected $mediaId;

    /**
     * Response constructor.
     * @param $mediaId
     */
    public function __construct($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * @return int
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }
}
