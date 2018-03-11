<?php
/**
 * Created by PhpStorm.
 * User: guigui
 * Date: 04/03/2018
 * Time: 15:01
 */

namespace AppBundle\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use AppBundle\Services\Twitter\Exception;
use AppBundle\Services\Twitter\Media\Response as MediaResponse;
use AppBundle\Services\Twitter\Tweet\Request as TweetRequest;
use AppBundle\Services\Twitter\Tweet\Response as TweetResponse;
use Psr\Log\LoggerInterface;

class TwitterApi
{

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $accessTokenSecret;

    protected $twitter;


    public function __construct(string $apiKey, string $apiSecret, string $accessToken, string $accessTokenSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->accessToken = $accessToken;
        $this->accessTokenSecret = $accessTokenSecret;
        $this->twitter = new TwitterOAuth(
            $this->apiKey,
            $this->apiSecret,
            $this->accessToken,
            $this->accessTokenSecret
        );
    }

    /**
     * @param string $imagePath
     * @return MediaResponse
     */
    public function postMedia(string $imagePath)
    {
        if (!file_exists($imagePath)) {
            throw new \InvalidArgumentException("Image $imagePath could not be found");
        }

        $this->twitter->setTimeouts(60, 30);
        $result = $this->twitter->upload('media/upload', ['media' => $imagePath]);
        return $this->buildMediaResponse($result);
    }

    /**
     * @param TweetRequest $tweetRequest
     * @return \stdClass
     */
    public function postTweet(TweetRequest $tweetRequest)
    {
        $parameters = [
            'status' => $tweetRequest->getStatus(),
            'media_ids' => $tweetRequest->getMedias()
        ];
        $result = $this->twitter->post('statuses/update', $parameters);
        return $this->buildTweetResponse($result);
    }

    /**
     * @param \stdClass $rawTweetResponse
     * @return \stdClass
     * @throws Exception
     */
    protected function buildTweetResponse(\stdClass $rawTweetResponse)
    {
        if (!isset($rawTweetResponse->id)) {
            throw new Exception("An id key was expected in the response : " . var_export($rawTweetResponse, true));
        }
        $tweetResponse = new TweetResponse($rawTweetResponse->id);
        return $tweetResponse;
    }

    /**
     * @param \stdClass $rawMediaResponse
     * @return MediaResponse
     * @throws Exception
     */
    protected function buildMediaResponse(\stdClass $rawMediaResponse)
    {
        if (!isset($rawMediaResponse->media_id)) {
            throw new Exception("A media_id key was expected in the response : " . var_export($rawMediaResponse, true));
        }
        $mediaResponse = new MediaResponse($rawMediaResponse->media_id);
        return $mediaResponse;
    }

}
