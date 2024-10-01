<?php

namespace App\Http\Controllers;

use App\Interfaces\ShapesStrategy;
use Illuminate\Http\Request;

class ShapesController extends Controller
{
    protected $shapeClasses = [];

    public function __construct()
    {
        $this->registerShapeClasses();
    }

    /**
     * Register shape classes that implement the ShapesStrategy interface.
     */
    protected function registerShapeClasses()
    {
        $shapeDir = app_path('Classes/Shapes'); // Change this to your actual shape classes directory
        $files = scandir($shapeDir);

        foreach ($files as $file) {
            // Only look for PHP files
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Get the class name
                $className = 'App\\Classes\\Shapes\\' . pathinfo($file, PATHINFO_FILENAME);

                // Check if the class exists and implements the ShapesStrategy interface
                if (class_exists($className) && in_array(ShapesStrategy::class, class_implements($className))) {
                    $shapeKey = strtolower(pathinfo($file, PATHINFO_FILENAME)); // Use the file name as the shape key
                    $this->shapeClasses[$shapeKey] = $className;
                }
            }
        }
    }

    /**
     * Process the requested shape and echo its dimensions.
     *
     * @param string $shape The type of shape (circle, triangle, etc.).
     * @param mixed $dimension1 The first dimension (e.g., radius or base).
     * @param mixed|null $dimension2 The second dimension (e.g., height), if applicable.
     * @return \Illuminate\Http\JsonResponse
     */
    public function processShape(string $shape, $dimension1, $dimension2 = null)
    {
        // Check if the shape exists in the registered classes
        if (!array_key_exists($shape, $this->shapeClasses)) {
            return response()->json(['error' => 'Shape not found'], 404);
        }

        // Dynamically instantiate the shape class
        $shapeClass = $this->shapeClasses[$shape];

        // Create the shape instance with the provided dimensions

        $shapesStrategy = new $shapeClass($dimension1, $dimension2);

        // Echo dimensions based on the shape strategy selected
        return response()->json(['dimensions' => $shapesStrategy->echoDimension()]);
    }
}
