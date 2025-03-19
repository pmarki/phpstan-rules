<?php

namespace MethodRules;

class NoAbstractClass {
    protected function protectedMethod() {} // bad
    public function publicMethod() {} // good
    private function privateMethod() {} // good
    private function _underscore() {} // no underscore
    protected function _underscoreProtected() {} // no underscore
    public function __construct() {} // good
}
