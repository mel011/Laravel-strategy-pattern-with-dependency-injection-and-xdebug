<?php
namespace App\Classes\Shapes;

use App\Interfaces\ShapesStrategy;

class Circle implements ShapesStrategy
{
    protected $radius;

    public function __construct($radius)
    {
        // Assuming radius is passed as a string, extract the numeric value
        $this->radius = floatval($radius);
    }

    public function echoDimension()
    {
        return [
            'type' => 'circle',
            'radius' => $this->radius,
            'area' => pi() * pow($this->radius, 2),
            'circumference' => 2 * pi() * $this->radius,
        ];
    }
}
