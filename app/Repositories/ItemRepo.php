<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ItemRepoInterface;
use Illuminate\Support\Facades\File;

class ItemRepo implements ItemRepoInterface
{
    protected $filePath;

    public function __construct(string $path)
    {
        $this->filePath = base_path().$path;
    }

    private function decodeFile()
    {
        return json_decode(File::get($this->filePath), true);
    }

    public function save(array $item)
    {
        $items = $this->decodeFile();
        $items[] = $item;
        File::put($this->filePath, json_encode($items, JSON_PRETTY_PRINT));
    }

    public function get()
    {
        $items = $this->decodeFile();

        return $items;
    }
}
