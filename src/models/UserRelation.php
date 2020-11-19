<?php

namespace Devbook\models;

class UserRelation
{
    private int $id;
    private int $user_from;
    private int $user_to;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserFrom(): int
    {
        return $this->user_from;
    }

    /**
     * @param int $user_from
     */
    public function setUserFrom(int $user_from): void
    {
        $this->user_from = $user_from;
    }

    /**
     * @return int
     */
    public function getUserTo(): int
    {
        return $this->user_to;
    }

    /**
     * @param int $user_to
     */
    public function setUserTo(int $user_to): void
    {
        $this->user_to = $user_to;
    }
}
