<?php

namespace MethodRules;

abstract class AbstractClass {
    protected function protectedMethod() {} // good
    public function publicMethod() {} // good
    private function privateMethod() {} // good
    private function _underscore() {} // no underscore
    protected function _underscoreProtected() {} // no underscore
    public function __construct() {} // good
}
