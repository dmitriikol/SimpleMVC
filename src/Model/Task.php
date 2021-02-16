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

    public static function get(string $id): array
    {
        /** @var \PDO $db */
        $db = static::getDB();

        $stmt = $db->prepare("select * from tasks where id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch();
    }

    public static function delete(string $id): void
    {
        /** @var \PDO $db */
        $db = static::getDB();

        $stmt = $db->prepare("delete from tasks where id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $stmt->execute();
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

    public static function updateTask(
        string $id,
        string $username,
        string $email,
        string $text,
        bool $status = false
    ): void
    {
        /** @var \PDO $db */
        $db = static::getDB();

        $stmt = $db->prepare("update tasks set username=?, email=?, text=?, status=? where id=?");

        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $stmt->bindParam(3, $text, PDO::PARAM_STR);
        $stmt->bindParam(4, $status, PDO::PARAM_BOOL);
        $stmt->bindParam(5, $id, PDO::PARAM_INT);

        var_dump($stmt->queryString);
        $stmt->execute();
    }

}