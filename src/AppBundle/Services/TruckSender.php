<?php
/**
 * Created by PhpStorm.
 * User: guigui
 * Date: 04/03/2018
 * Time: 14:49
 */

namespace AppBundle\Services;

use AppBundle\Services\Twitter\Tweet\Request as TweetRequest;
use Psr\Log\LoggerInterface;

class TruckSender
{
    /**
     * @var TwitterApi
     */
    protected $twitterApi;

    protected $logger;

    /**
     * TruckSender constructor.
     * @param TwitterApi $twitterApi
     */
    public function __construct(TwitterApi $twitterApi, LoggerInterface $logger)
    {
        $this->twitterApi = $twitterApi;
        $this->logger     = $logger;
    }

    /**
     * @return bool
     */
    public function send()
    {
        $mediaResponse = $this->sendImage($this->getImage());
        if (!$mediaResponse) {
            return false;
        }

        return $this->sendTweet(
            $this->getStatus(),
            $mediaResponse->getMediaId()
        );
    }

    /**
     * @return string
     */
    protected function getStatus()
    {
        return 'TUUT T' . str_repeat('U', rand(3, 5)) . 'T T' . str_repeat('U', rand(5, 9)) . 'T';
    }

    /**
     * @param string $status
     * @param int $media
     * @return bool
     */
    protected function sendTweet(string $status, int $media)
    {
        $tweetRequest = new TweetRequest($status, $media);
        try {
            return $this->twitterApi->postTweet($tweetRequest);
        }  catch (\Exception $e) {
            $this->logger->error('An error occured while sending the tweet : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $webImagePath
     * @return Twitter\Media\Response|bool
     */
    protected function sendImage(string $webImagePath)
    {
        try {
            return $this->twitterApi->postMedia($webImagePath);
        } catch (\Exception $e) {
            $this->logger->error('An error occured while sending image ' . $webImagePath . '.' . $e->getMessage());
            return false;
        }
    }

    /**
     * @return string
     */
    protected function getImage()
    {
        return 'web' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'camion' . rand(1, 6) . '.jpg';
    }
}
