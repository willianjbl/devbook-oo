<?php


namespace Devbook\models;


class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $birthdate;
    private string $city;
    private string $work;
    private string $avatar;
    private string $cover;
    private string $token;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        if (!empty($name)) {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        if (!empty($email)) {
            $this->email = $email;
        }
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        if (!empty($password)) {
            $this->password = $password;
        }
    }

    /**
     * @return string
     */
    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    /**
     * @param string|null $birthdate
     */
    public function setBirthdate(?string $birthdate): void
    {
        if (!empty($birthdate)) {
            $this->birthdate = $birthdate;
        }
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        if (!empty($city)) {
            $this->city = $city;
        }
    }

    /**
     * @return string
     */
    public function getWork(): ?string
    {
        return $this->work;
    }

    /**
     * @param string|null $work
     */
    public function setWork(?string $work): void
    {
        if (!empty($work)) {
            $this->work = $work;
        }
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        if (!empty($avatar)) {
            $this->avatar = $avatar;
        }
    }

    /**
     * @return string
     */
    public function getCover(): ?string
    {
        return $this->cover;
    }

    /**
     * @param string|null $cover
     */
    public function setCover(?string $cover): void
    {
        if (!empty($cover)) {
            $this->cover = $cover;
        }
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        if (!empty($token)) {
            $this->token = $token;
        }
    }

    public function isEmpty(): bool
    {
        return count((array)$this) === 0;
    }
}
