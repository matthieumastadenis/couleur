<?php

namespace matthieumastadenis\couleur\exceptions;

class   MissingColorValue
extends \Exception {

    public function __construct(
        string          $name,
        int             $code     = 0,
        \Throwable|null $previous = null,
    ) {
        parent::__construct(
            message  : "Color value \"$name\" is missing",
            code     : $code,
            previous : $previous,
        );
    }
}
