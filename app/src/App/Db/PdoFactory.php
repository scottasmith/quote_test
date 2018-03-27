<?php

declare(strict_types=1);

namespace App\Db;

use Psr\Container\ContainerInterface;
use PDO;

class PdoFactory
{
    public function __invoke(ContainerInterface $container): PDO
    {
        $data = $this->getConfig($container);

        $dsn = sprintf('mysql:host=%s;dbname=%s', $data['host'], $data['db']);

        return new PDO($dsn, $data['user'], $data['pass']);
    }

    private function getConfig(ContainerInterface $container)
    {
        $config = $container->get('config');

        if (!isset($config['database_conn'])) {
            throw new \Exception('Database Connection config not found');
        }

        return $config['database_conn'];
    }
}
