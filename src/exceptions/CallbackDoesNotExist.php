<?php

namespace matthieumastadenis\couleur\exceptions;

class   CallbackDoesNotExist
extends \Exception {

    public function __construct(
        string          $callback,
        int             $code     = 0,
        \Throwable|null $previous = null,
    ) {
        parent::__construct(
            message  : "Callback $callback does not exist",
            code     : $code,
            previous : $previous,
        );
    }
}
