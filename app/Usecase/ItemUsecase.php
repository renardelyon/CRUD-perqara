<?php

namespace App\Usecase;

use App\Repositories\Interfaces\ItemRepoInterface;
use App\Usecase\Interfaces\ItemUsecaseInterface;
use RangeException;

class ItemUsecase implements ItemUsecaseInterface
{
    private ItemRepoInterface $itemRepository;

    public function __construct(ItemRepoInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function saveItem($name, $price)
    {
        $item = [
            "name" => $name,
            "price" => $price
        ];

        $this->itemRepository->save($item);
    }

    public function getAllItem(): array
    {
        return $this->itemRepository->get();
    }

    public function calculateItemQuantityBasedOnSummedMoney(array $money): array
    {
        $items = $this->getAllItem();

        $price = array_column($items, 'price');
        array_multisort($price, SORT_DESC, $items);

        $sum = 0;

        foreach($money as $m) {
            if ($m != 2000 && $m != 5000) {
                throw new RangeException("invalid denomination");
            }

            $sum += $m;
        }

        $receivedItems = array();

        foreach($items as $item) {
            if ($item["price"] > $sum) {
                continue;
            }

            $remainder = $sum % $item["price"];
            $quantity = $sum / $item["price"];

            $receivedItems[] = [
                "name" => $item["name"],
                "quantity" => $quantity
            ];

            $sum = $remainder;
        }


        return $receivedItems;
    }
}
