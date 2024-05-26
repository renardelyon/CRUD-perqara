<?php

namespace App\Usecase\Interfaces;

interface ItemUsecaseInterface
{
    public function saveItem($name, $price);
    public function getAllItem(): array;
    public function calculateItemQuantityBasedOnSummedMoney(array $money): array;
}
