<?php

namespace src\Decorator;

use Exception;
use Psr\Log\LoggerInterface;

/**
 * Декоратор добавляет логику логирования к запросу в стороннее API
 */
class Logger extends DecoratorManager
{
    /** @var  LoggerInterface*/
    private $logger;

    /**
     * @param DataProviderInterface $dataProvider
     * @param LoggerInterface $logger
     */
    public function __construct(DataProviderInterface $dataProvider, LoggerInterface $logger)
    {
        $this->logger = $logger;

        parent::__construct($dataProvider);
    }

    /**
     * {@inheritDoc}
     */
    public function get(array $request): array
    {
        try {
            $result = $this->dataProvider->get($request);
            return $result;
        } catch (Exception $e) {
            $this->logger->critical('Ошибка получения запроса: ' . $e->getMessage());
        }

        return [];
    }
}
