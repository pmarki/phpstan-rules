<?php

namespace ConstRules;

class NoAbstractClass {
    const ABC = 1; // missing visibility
    const CDE = 1, // only one per statement
        EFG = 2;
    public const PUBLIC_CONST = 1; // good
    protected const PROTECTED_CONST = 1; // no protected
    public const lowercase = 1; // must be uppercase
    const foo = 1; // must be uppercase and missing modifier
}
