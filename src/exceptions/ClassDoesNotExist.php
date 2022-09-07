<?php

namespace matthieumastadenis\couleur\exceptions;

class   ClassDoesNotExist
extends \Exception {

    public function __construct(
        string          $class, 
        int             $code     = 0, 
        \Throwable|null $previous = null,
    ) {
        parent::__construct(
            message  : "Class $class does not exist",
            code     : $code,
            previous : $previous,
        );
    }
}