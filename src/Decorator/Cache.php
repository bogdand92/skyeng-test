<?php

namespace src\Decorator;

use DateTime;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Декоратор кеширует ответы от стороннего API
 */
class Cache extends DecoratorManager
{
    /** @var CacheItemPoolInterface */
    private $cache;

    /**
     * @param DataProviderInterface $dataProvider
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;

        parent::__construct($dataProvider);
    }

    /**
     * {@inheritDoc}
     */
    public function get(array $request): array
    {
        $cacheKey = $this->getCacheKey($request);
        $cacheItem = $this->cache->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $result = $this->dataProvider->get($request);

        $cacheItem
            ->set($result)
            ->expiresAt(
                (new DateTime())->modify('+1 day')
            );

        return $result;
    }

    /**
     * Метод возвращает ключ для кеширования
     *
     * @param array $input
     * @return string
     */
    private function getCacheKey(array $input): string
    {
        return json_encode($input);
    }
}
