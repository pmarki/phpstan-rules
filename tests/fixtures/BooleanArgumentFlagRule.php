<?php declare(strict_types=1);

namespace BooleanArgumentFlagRule;

function boolFlag(int $int, bool $bool)
{
}

function boolDoubleFlag(int $int, bool $bool1, bool $bool2)
{
}

function noBoolFlag(int $int, string $string)
{
}

class BooleanArgumentFlagRule
{
    public function boolFlag(int $int, bool $bool)
    {
    }

    private function noBoolFlag(int $int, string $string)
    {
    }

    /**
     * @param int $int
     * @param bool $bool
     * @return void
     */
    public function boolFlagNoType($int, $bool)
    {
    }

    public function boolUnionFlag(int $int, bool|int $bool)
    {
    }
}
