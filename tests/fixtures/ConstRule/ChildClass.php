<?php

namespace ConstRules;

class ChildClass extends AbstractClass {
    const ABC = 1; // Good, inherited
    const CDE = 1, // only one per statement
        EFG = 2;
    public const CHILD_PUBLIC_CONST = 1; // good
    protected const PROTECTED_CONST = 1; // good, inherited
    protected const CHILD_PROTECTED_CONST = 1; // no protected
    public const lowercase = 1; // Good, inherited
    const foo = 1; // Good, inherited

    public const child_lowercase = 1; // must be uppercase
    const child_foo = 1; // must be uppercase and missing modifier
}
