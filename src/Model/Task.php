<?php

namespace App\Model;

use PDO;

class Task extends Model
{
    public static function getAll(): array
    {
        /** @var \PDO $db */
        $db = static::getDB();
        $stmt = $db->query("select * from tasks");
        return $stmt->fetchAll();
    }

    public static function addTask(
        string $username,
        string $email,
        string $text,
        bool $status = false
    ): void
    {
        /** @var \PDO $db */
        $db = static::getDB();

        $stmt = $db->prepare("INSERT INTO tasks(username, email, text, status) VALUES(?, ?, ?, ?)");

        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $text, PDO::PARAM_STR);
        $stmt->bindParam(4, $status, PDO::PARAM_BOOL);

        $stmt->execute();
    }

}