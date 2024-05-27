<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateItemRequest;
use App\Http\Requests\InsertItemRequest;
use App\Usecase\Interfaces\ItemUsecaseInterface;
use RangeException;

/**
* @OA\Info(
*      version="1.0.0",
*      title="API Documentation",
*      @OA\Contact(
*          email="renard.elyon.r@gmail.com"
*      ),
*      @OA\License(
*          name="Apache 2.0",
*          url="http://www.apache.org/licenses/LICENSE-2.0.html"
*      )
* )
*
* @OA\Server(
*      url=L5_SWAGGER_CONST_HOST,
*      description="API Server"
* )
*/
class ItemController extends Controller
{
    private ItemUsecaseInterface $itemUsecase;

    public function __construct(ItemUsecaseInterface $itemUsecase)
    {
        $this->itemUsecase = $itemUsecase;
    }

    /**
     * @OA\Post(
     *     path="/items",
     *     summary="Insert an item",
     *     tags={"Items"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Name of the item"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="integer",
     *                 description="Price of the item"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="status_message",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             )
     *         )
     *     )
     * )
     */
    public function insertItem(InsertItemRequest $request)
    {
        $input = $request->all();

        $this->itemUsecase->saveItem($input["name"], $input["price"]);

        return response()->json([], 200, ['Content-Type' => 'application/json']);
    }

    /**
    * @OA\Get(
    *     path="/items",
    *     summary="Get all items",
    *     tags={"Items"},
    *     @OA\Response(
    *         response=200,
    *         description="items",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(
    *                 property="status_code",
    *                 type="integer"
    *             ),
    *             @OA\Property(
    *                 property="status_message",
    *                 type="string"
    *             ),
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(
    *                   type="object",
    *                  @OA\Property(
    *                      property="name",
    *                      type="string"
    *                   ),
    *                  @OA\Property(
    *                      property="price",
    *                      type="integer"
    *                   ),
    *                 ),
    *             )
    *         )
    *     )
    * )
    */
    public function getAllItem()
    {
        $items = $this->itemUsecase->getAllItem();

        return response()->json($items, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @OA\Post(
     *     path="/calculate-items",
     *     summary="calculate items based on money",
     *     tags={"Items"},
     *     @OA\RequestBody(
     *         required=true,
     *             @OA\JsonContent(
     *                  @OA\Property(
     *                      property="money",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          example={1,2}
     *                      ),
     *                  ),
     *              )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status_code",
     *                 type="integer"
     *             ),
     *             @OA\Property(
     *                 property="status_message",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object"
     *             )
     *         )
     *     )
     * )
     */
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
