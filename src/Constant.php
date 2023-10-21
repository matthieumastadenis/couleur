<?php

namespace matthieumastadenis\couleur;

use       matthieumastadenis\couleur\utils;

/**
 * Represents a configuration constant accepted by Couleur.
 * Allows to easily define the constant and/or access its default value.
 *
 * All supported constants are in uppercase and prefixed with 'COULEUR_'.
 */
enum Constant :int {

    /* #region Cases */

    case LEGACY    = 0;
    case PRECISION = 9;

    /* #endregion */

    /* #region Public Methods */

    /**
     * Returns the value of the current constant if it exists.
     *
     * If the constant exists but is not defined, returns its default value or $value if provided.
     * If the constant does not exists, returns $value.
     *
     * If $create is set to true, the constant will be defined with $value as a value.
     *
     * @param  mixed   $value  Fallback value (also used to define the constant if $create is true)
     * @param  boolean $create If true the constant will be defined with $value as a value
     *
     * @return mixed           The constant value if it exists and is declared, its default value or $value otherwise
     */
    public function value(
        int|null $value  = null,
        bool     $create = false,
    ) :int {
        return (int) utils\constant(
            name   : $this->name,
            value  : $value ?? $this->value,
            create : $create,
        );
    }

    /* #endregion */

}
