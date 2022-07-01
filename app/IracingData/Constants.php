<?php

namespace App\IracingData;

class Constants
{
    public const LIC_CLASSES = [
        1 => 'license-r',
        2 => 'license-d',
        3 => 'license-c',
        4 => 'license-b',
        5 => 'license-a',
        6 => 'license-pro',
        7 => 'license-prowc',
    ];
    
    public const LIC_NAMES = [
        1 => 'Rookie',
        2 => 'Class D',
        3 => 'Class C',
        4 => 'Class B',
        5 => 'Class A',
        6 => 'Pro',
        7 => 'Pro/WC',
    ];

    public const LIC_SHORT = [
        1 => 'R',
        2 => 'D',
        3 => 'C',
        4 => 'B',
        5 => 'A',
        6 => 'P',
        7 => 'W',
    ];

    public const CATEGORIES = [
        1 => 'Oval',
        2 => 'Road',
        3 => 'Dirt oval',
        4 => 'Dirt road'
    ];

    public const CAT_ICONS = [
        1 => '&#xE0B7;',
        2 => '&#xE0CE;',
        3 => '&#xE0B8;',
        4 => '&#xE0D0;'
    ];
}