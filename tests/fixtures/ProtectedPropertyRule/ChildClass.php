<?php

namespace PropertyRules;

class ChildClass extends AbstractClass {
    public $publicProperty; // good
    private $privateProperty; // good
    protected $protectedProperty; // good
    protected $protectedChild; // not inherited

    private $p1, // good, one per statement
        $p2;

    private $_nameWithUnderscore; // bad

    public function __construct(
        private $privatePromoted,
        protected $protectedPromoted,
        protected $protectedChildPromoted,
    ) {}
}
