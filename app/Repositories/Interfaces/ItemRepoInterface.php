<?php

namespace App\Repositories\Interfaces;

interface ItemRepoInterface
{
    public function save(array $item);
    public function get();
}
