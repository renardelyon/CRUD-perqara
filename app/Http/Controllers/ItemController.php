<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateItemRequest;
use App\Http\Requests\InsertItemRequest;
use App\Usecase\Interfaces\ItemUsecaseInterface;
use RangeException;

class ItemController extends Controller
{
    private ItemUsecaseInterface $itemUsecase;

    public function __construct(ItemUsecaseInterface $itemUsecase)
    {
        $this->itemUsecase = $itemUsecase;
    }

    public function insertItem(InsertItemRequest $request)
    {
        $input = $request->all();

        $this->itemUsecase->saveItem($input["name"], $input["price"]);

        return response()->json([], 200, ['Content-Type' => 'application/json']);
    }

    public function getAllItem()
    {
        $items = $this->itemUsecase->getAllItem();

        return response()->json($items, 200, ['Content-Type' => 'application/json']);
    }

    public function calculateItemQuantity(CalculateItemRequest $request)
    {
        $input = $request->all();

        $result = array();

        try {
            $result = $this->itemUsecase->calculateItemQuantityBasedOnSummedMoney($input["money"]);
        } catch(RangeException $e) {
            return response()->json($e->getMessage(), 400, ['Content-Type' => 'application/json']);
        }

        return response()->json($result, 200, ['Content-Type' => 'application/json']);
    }
}
