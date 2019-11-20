<?php

namespace src\Decorator;

use src\Integration\{DataProvider, DataProviderInterface};

/**
 * Базовый декоратор, который оборачивает собой сервис (я бы тут написал какой, но по условию задания не понял :( )
 */
class DecoratorManager implements DataProviderInterface
{
    /** @var DataProviderInterface */
    protected $dataProvider;

    /**
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * Получить оригинальный запрос из стороннего апи
     *
     * @param array $request
     * @return array
     */
    public function get(array $request): array
    {
        return $this->dataProvider->get($request);
    }
}
