<?php
namespace App\Db;

use App\Db\Connection;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

final class InvokableDalFactory implements FactoryInterface
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameters)
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (!class_exists($requestedName)) {
            throw new \Exception('Dal class does not exist: ' . $requestedName);
        }

        return new $requestedName($container->get(Connection::class));
    }
}