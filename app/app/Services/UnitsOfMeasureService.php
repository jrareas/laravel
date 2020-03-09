<?php

namespace App\Services;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;

class UnitsOfMeasureService extends AbstractPhysicalQuantity
{
    private $available_definitions = [];

    private $class_map = [
        "length" => 'PhpUnitsOfMeasure\PhysicalQuantity\Length',
        "mass" => 'PhpUnitsOfMeasure\PhysicalQuantity\Mass',
    ];
    public function getDefinitions() {
        foreach ($this->class_map as $key=>$class) {
            $obj = new $class(1,'g');

        }
    }
}