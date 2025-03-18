<?php

namespace MethodRules;

interface Foo
{
    function _underscoreProtected(); // bad, no leading underscore
}

class ChildClass implements Foo
{
    public function _underscoreProtected() {} // good, inherited
}
