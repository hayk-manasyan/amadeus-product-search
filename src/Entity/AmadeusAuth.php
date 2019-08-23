<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmadeusAuthRepository")
 */
class AmadeusAuth
{
    private function __construct()
    {
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $application_name;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $client_id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $token_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $access_token;

    /**
     * @ORM\Column(type="integer")
     */
    private $expires_in;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $scope;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getApplicationName(): ?string
    {
        return $this->application_name;
    }

    public function setApplicationName(string $application_name): self
    {
        $this->application_name = $application_name;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getTokenType(): ?string
    {
        return $this->token_type;
    }

    public function setTokenType(string $token_type): self
    {
        $this->token_type = $token_type;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    public function setAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }

    public function getExpiresIn(): ?int
    {
        return $this->expires_in;
    }

    public function setExpiresIn(int $expires_in): self
    {
        $this->expires_in = $expires_in;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(?string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public static function initAmadeusAuth(
        $type,
        $username,
        $applicationName,
        $accessToken,
        $clientId,
        $tokenType,
        $expiresIn,
        $state,
        $scope
    ): self {
        $amadeusAuth = new self();
        $amadeusAuth->setType($type);
        $amadeusAuth->setUsername($username);
        $amadeusAuth->setApplicationName($applicationName);
        $amadeusAuth->setAccessToken($accessToken);
        $amadeusAuth->setClientId($clientId);
        $amadeusAuth->setTokenType($tokenType);
        $amadeusAuth->setExpiresIn($expiresIn);
        $amadeusAuth->setState($state);
        $amadeusAuth->setScope($scope);
        $amadeusAuth->setCreateDate(new \DateTime('now'));

        return $amadeusAuth;
    }
}
