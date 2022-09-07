<?php

namespace matthieumastadenis\couleur\exceptions;

class   UnsupportedCssColor 
extends \Exception {

    public function __construct(
        string          $name,
        int             $code     = 0, 
        \Throwable|null $previous = null,
    ) {
        parent::__construct(
            message  : "Css color \"$name\" is not supported",
            code     : $code,
            previous : $previous,
        );
    }
}