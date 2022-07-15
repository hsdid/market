<?php
declare(strict_types=1);
namespace App\Tests\Integration\Infrastructure\Core;

use PDO;
use PDOStatement;

final class TokenProvider
{
    /**
     * @var static|null
     */
    private static $instance = null;
    /**
     * @var false|PDOStatement
     */
    private $select;
    /**
     * @var false|PDOStatement
     */
    private $insert;

    private function __construct()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->query('CREATE TABLE IF NOT EXISTS tokens_cache(type TEXT, username TEXT, token TEXT)');
        $this->select = $pdo->prepare('SELECT token FROM tokens_cache WHERE type = :type AND username = :username');
        $this->insert = $pdo->prepare('INSERT INTO tokens_cache VALUES (:type, :username, :token)');
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public function getToken(string $type, string $username): ?string
    {
        $this->select->execute([
            ':username' => $username,
        ]);

        return $this->select->fetchColumn() ?: null;
    }

    public function addToken(string $type, string $username, string $token): void
    {
        $this->insert->execute([
            ':type' => $type,
            ':username' => $username,
            ':token' => $token,
        ]);
    }

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}