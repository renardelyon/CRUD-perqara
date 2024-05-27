<?php

namespace Tests\Feature;

use App\Repositories\ItemRepo;
use App\Usecase\ItemUsecase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ItemUsecaseTest extends TestCase
{
    public function test_get_all_items()
    {
        $data = [
            "name" => "Sosro",
            "price" => 10000
        ];

        $mockRepo = tap(Mockery::mock(ItemRepo::class), function (MockInterface $mock) use ($data) {
            $mock->shouldReceive("get")->once()->andReturn($data);
        });

        $result = (new ItemUsecase($mockRepo))->getAllItem();

        $this->assertEqualsCanonicalizing($data, $result);
    }

    public function test_save_item()
    {
        $data = [
            "name" => "Sosro",
            "price" => 10000
        ];

        $mockRepo = tap(Mockery::mock(ItemRepo::class), function (MockInterface $mock) use ($data) {
            $mock->shouldReceive("save")->with($data)->once();
        });

        (new ItemUsecase($mockRepo))->saveItem($data["name"], $data["price"]);
    }

    public function test_calculate_items()
    {
        $data = [
            [
                "name" => "Milo",
                "price" => 2000
            ],
            [
                "name" => "Kopi",
                "price" => 5000
            ],
            [
                "name" => "Sosro",
                "price" => 10000
            ]
        ];

        $mockRepo = tap(Mockery::mock(ItemRepo::class), function (MockInterface $mock) use ($data) {
            $mock->shouldReceive("get")->once()->andReturn($data);
        });

        $result = (new ItemUsecase($mockRepo))->calculateItemQuantityBasedOnSummedMoney([5000,5000]);

        $expected = [
            [
                "name" => "Sosro",
                "price" => 1
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $result);
    }
}
