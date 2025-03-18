<?php

namespace MethodRules;

class ChildClass extends AbstractClass
{
    protected function protectedMethod() {} // good
    protected function childMethod() {} // no inherited
    public function publicMethod() {} // good
    private function privateMethod() {} // good
    private function _underscore() {} // no underscore
    protected function _underscoreProtected() {} // good, inherited
    public function __get($name) {} // good
}
