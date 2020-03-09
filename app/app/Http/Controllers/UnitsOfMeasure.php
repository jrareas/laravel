<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpUnitsOfMeasure\PhysicalQuantity;
use App\Services\UnitsOfMeasureService;

class UnitsOfMeasure extends Controller
{
    private $class_map = [
        "area" => 'PhpUnitsOfMeasure\PhysicalQuantity\Area',
        "angle" => 'PhpUnitsOfMeasure\PhysicalQuantity\Angle',
        "eletric_current" => "PhpUnitsOfMeasure\PhysicalQuantity\ElectricCurrent",
        "energy" => 'PhpUnitsOfMeasure\PhysicalQuantity\Energy',
        "length" => 'PhpUnitsOfMeasure\PhysicalQuantity\Length',
        "mass" => 'PhpUnitsOfMeasure\PhysicalQuantity\Mass',
        "velocity" => 'PhpUnitsOfMeasure\PhysicalQuantity\Velocity',
    ];

    public function index(Request $request, $physical_quantity) {
        return $this->getValue($request, $this->class_map[$physical_quantity]);
    }
    public function area (Request $request) {
        return $this->getValue($request, $this->class_map["area"]);
    }

    public function angle (Request $request) {
        return $this->getValue($request, $this->class_map["angle"]);
    }

    public function eletric_current (Request $request) {
        return $this->getValue($request, $this->class_map["eletric_current"]);
    }

    public function energy (Request $request) {
        return $this->getValue($request, $this->class_map["energy"]);
    }

    public function length(Request $request) {
        return $this->getValue($request, $this->class_map["length"]);
    }

    public function mass(Request $request) {
        return $this->getValue($request, $this->class_map["mass"]);
    }

    public function velocity(Request $request) {
        return $this->getValue($request, $this->class_map["velocity"]);
    }

    private function getValue($request, $class) {
        $unitFrom = $request->get('unitFrom');
        $unitTo = $request->get('unitTo');
        $value = $request->get('value');
        $obj =  new $class($value, $unitFrom);
        return response(["data" => $obj->toUnit($unitTo)]) ;
    }
}
