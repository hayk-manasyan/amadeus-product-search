<?php

namespace App\Service\Amadeus;

use App\Entity\AmadeusAuth;
use App\Repository\AmadeusAuthRepository;
use Doctrine\ORM\NonUniqueResultException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class AmadeusAuthorization
{
    const OAUTH_PATH = '';

    /**
     * @var string
     */
    private $baseUrl;
    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var string
     */
    private $apiSecret;

    /**
     * @var AmadeusAuthRepository
     */
    private $amadeusAuthRepository;

    /** @var AmadeusAuth */
    private static $_amadeusAuth;

    /**
     * AmadeusAuthorization constructor.
     *
     * @param string                $baseUrl
     * @param string                $apiKey
     * @param string                $apiSecret
     * @param AmadeusAuthRepository $amadeusAuthRepository
     */
    public function __construct(
        string $baseUrl,
        string $apiKey,
        string $apiSecret,
        AmadeusAuthRepository $amadeusAuthRepository
    ) {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->amadeusAuthRepository = $amadeusAuthRepository;
    }

    /**
     * @return AmadeusAuth
     * @throws \Exception
     */
    public function getAuth(): AmadeusAuth
    {
        $date = new \DateTime('now');
        $date->add(new \DateInterval('PT30M'));
        $untilDate = $date->format('Y-m-d H:i:s');

        $amadeusAuth = null;
        if (is_null(static::$_amadeusAuth)) {
            try {
                $amadeusAuth = $this->amadeusAuthRepository->findActiveAccessToken($untilDate);
            } catch (NonUniqueResultException $nEx) {

            }


            //TODO fix quick fix
            if (!is_null($amadeusAuth) && $amadeusAuth->getCreateDate() > $untilDate) {
                $amadeusAuth = null;
            }
        }
        if (is_null($amadeusAuth)) {
            $amadeusAuth = $this->authorize();
        }

        static::$_amadeusAuth = $amadeusAuth;

        return static::$_amadeusAuth;
    }

    private function authorize()
    {
        $client = new Client();
        try {
            $response = $client->request('POST', $this->baseUrl.$this->oauthPath, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->apiKey,
                    'client_secret' => $this->apiSecret,
                ],
            ]);
        } catch (GuzzleException $exception) {
            echo $exception->getMessage();
            die;
        }

        $body = json_decode($response->getBody(), true);
        $amadeusAuth = AmadeusAuth::initAmadeusAuth(
            $body['type'],
            $body['username'],
            $body['application_name'],
            $body['access_token'],
            $body['client_id'],
            $body['token_type'],
            $body['expires_in'],
            $body['state'],
            $body['scope']
        );

        $this->amadeusAuthRepository->save($amadeusAuth);

        return $amadeusAuth;
    }
}
