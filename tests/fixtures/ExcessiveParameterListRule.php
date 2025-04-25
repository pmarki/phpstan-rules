<?php
namespace ExcessiveParameterListRule;

class ExcessiveParameterListRule
{
    private function tooLong(
        $a1,
        $a2,
        $a3,
        $a4,
        $a5,
        $a6,
        $a7,
        $a8,
        $a9,
        $a10,
        $a11,
    ) {}

    private function good(
        $a1,
        $a2,
        $a3,
        $a4,
        $a5,
        $a6,
        $a7,
        $a8,
        $a9,
        $a10,
    ) {}
}

function tooLong(
    $a1,
    $a2,
    $a3,
    $a4,
    $a5,
    $a6,
    $a7,
    $a8,
    $a9,
    $a10,
    $a11,
) {}

function good(
    $a1,
    $a2,
    $a3,
    $a4,
    $a5,
    $a6,
    $a7,
    $a8,
    $a9,
    $a10,
) {}