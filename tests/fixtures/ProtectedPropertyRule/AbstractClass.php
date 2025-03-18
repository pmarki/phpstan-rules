<?php

namespace PropertyRules;

abstract class AbstractClass {
    protected $protectedProperty; // good
    public $publicProperty; // good
    private $privateProperty; // good

    private $p1, // good, one per statement
        $p2;

    private $_nameWithUnderscore; // bad

    public function __construct(
        private $privatePromoted,
        protected $protectedPromoted,
    ) {}
}
