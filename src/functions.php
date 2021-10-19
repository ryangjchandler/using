<?php

use RyanChandler\Using\Disposable;

if (! function_exists('using')) {
    /**
     * Enforce the disposal of the `Disposable` object.
     *
     * @template T of \RyanChandler\Using\Disposable
     * @param  T  $disposable
     * @param  callable(T): void  $callback
     * @return void
     */
    function using(Disposable $disposable, callable $callback): void
    {
        try {
            $callback($disposable);
        } finally {
            $disposable->dispose();
        }
    }
}
