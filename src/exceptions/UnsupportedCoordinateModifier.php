<?php

namespace matthieumastadenis\couleur\exceptions;

class   UnsupportedCoordinateModifier 
extends \Exception {

    public function __construct(
        string          $modifier, 
        int             $code     = 0, 
        \Throwable|null $previous = null,
    ) {
        parent::__construct(
            message  : "The coordinate modifier \"$modifier\" is not supported",
            code     : $code,
            previous : $previous,
        );
    }
}