<?php

use RyanChandler\Using\Disposable;

class TextFile implements Disposable
{
    public $resource;

    private $file;

    public function __construct(string $file, string $mode)
    {
        $this->file = $file;
        $this->resource = fopen($this->file, $mode);
    }

    public function read(int $length = null)
    {
        return fread($this->resource, $length ?? filesize($this->file));
    }

    public function dispose(): void
    {
        fclose($this->resource);

        $this->resource = null;
    }
}

it('throws an exception when non-disposable objects are passed', function () {
    $file = new TextFile(__DIR__ . '/fixtures/test.txt', 'r');

    using($file, function (TextFile $file) {
        expect($file->read())->toEqual("Hello, world!\n");
    });

    expect($file->resource)->toBeNull();
});
