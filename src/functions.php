<?php

use RyanChandler\Using\Disposable;

if (! function_exists('using')) {
    /**
     * Enforce the disposal of the `Disposable` object.
     *
     * @param  \RyanChandler\Using\Disposable  $disposable
     * @param  \Closure  $callback
     * @return void
     */
    function using(Disposable $disposable, Closure $callback): void
    {
        $callback($disposable);

        $disposable->dispose();
    }
}
