<?php

namespace App\Repositories\Interfaces;

interface ItemInterface {
    public function save(array $item);
    public function get();
}
