<?php

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use App\Shared\Domain\Bus\Query\QueryInterface;
use App\Shared\Domain\Bus\Query\ResponseInterface;

class InternalInMemoryQueryBus implements QueryBusInterface
{
    private static array $queries = [];
    private static array $results = [];

    private readonly array $queryHandlers;

    public function __construct(QueryHandlerInterface ...$queryHandlers)
    {
        $this->queryHandlers = $queryHandlers;
    }

    public function ask(QueryInterface $query): ?ResponseInterface
    {
        self::$queries[$query->getUuid()->toString()] = $query;

        $lastErrorMessage = '';
        $lastErrorTrace = '';

        foreach ($this->queryHandlers as $queryHandler) {
            try {
                $result = $queryHandler->__invoke($query);

                self::$results[$query->getUuid()->toString()] = $result;

                return $result;
            } catch (\Exception $e) {
                $lastErrorMessage = $e->getMessage();
                $lastErrorTrace = $e->getTraceAsString();
            }
        }

        throw new \Exception(sprintf('Missing Query Handler for %s. Error with message %s, %s', $query::class, $lastErrorMessage, $lastErrorTrace));
    }
}
