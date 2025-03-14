<?php

namespace PropertyRules;

class NoAbstractClass {
    protected $protectedProperty; // bad
    public $publicProperty; // good
    private $privateProperty; // good

    private $p1, // good
        $p2;

    private $_nameWithUnderscore; // bad

    public function __construct(
        private $privatePromoted,
        protected $protectedPromoted,
    ) {}
}
