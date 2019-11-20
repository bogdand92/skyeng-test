<?php

interface DataProviderInterface
{
    public function get(array $request): array;
}