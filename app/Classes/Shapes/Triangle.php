<?php
namespace App\Classes\Shapes;

use App\Interfaces\ShapesStrategy;

class Triangle implements ShapesStrategy
{
    protected $base;
    protected $height;

    public function __construct(string $dimension1,$dimension2)
    {
        // Assuming dimensions are passed in the format "base height"
        $dimensionArray = [$dimension1,$dimension2];

        if (count($dimensionArray) < 2) {
            throw new \InvalidArgumentException('Two dimensions (base and height) are required.');
        }

        // Extract and convert the base and height to floats
        $this->base = floatval($dimensionArray[0]);
        $this->height = floatval($dimensionArray[1]);
    }

    public function echoDimension()
    {
        return [
            'type' => 'triangle',
            'base' => $this->base,
            'height' => $this->height,
            'area' => 0.5 * $this->base * $this->height,
        ];
    }
}
