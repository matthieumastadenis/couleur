<?php

namespace matthieumastadenis\couleur\exceptions;

class   UnsupportedColorSpace 
extends \Exception {

    public function __construct(
        string          $space, 
        int             $code     = 0, 
        \Throwable|null $previous = null,
    ) {
        parent::__construct(
            message  : "The color space \"$space\" is not supported",
            code     : $code,
            previous : $previous,
        );
    }
}