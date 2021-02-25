<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP</title>
</head>

<body>
    <?php

    // interface to display class info
    interface IDisplay
    {
        public function Display();
    }

    // abstract class
    abstract class Car
    {
        protected $model;
        protected $speed;
        protected $color;

        protected static $id = 0;

        public function __construct($model, $speed, $color)
        {
            $this->model = $model;
            $this->speed = $speed;
            $this->color = $color;

            $this->welcome();
        }

        // abstract member function
        abstract public function welcome();
    }

    // child class that implements an interface
    class BMW extends Car implements IDisplay
    {
        private $name = "";
        private $carId = 0;

        public function __construct($model, $speed, $color, $name)
        {
            $this->model = $model;
            $this->speed = $speed;
            $this->color = $color;
            $this->name = $name;

            parent::$id++;
            $this->carId = parent::$id;

            $this->welcome();
        }

        public function welcome()
        {
            echo "Welcome to the BMW auto!";
        }

        // overloading abstract function
        public function Display()
        {
            echo "<h5>";

            echo "Car #$this->carId" . '<br>'
                . "Name: $this->name; Model: $this->model; Color: $this->color; Speed: $this->speed";

            echo "</h5>";
        }
    }

    class House
    {
        public $width = 0, $height = 0;
        public $floors = 0;
        public $residents = 0;
        public static $id = 0;
        private $houseId;

        public function __construct($width, $height, $floors, $residents = 0)
        {
            $this->width = $width;
            $this->height = $height;
            $this->floors = $floors;
            $this->residents = $residents;
            self::$id++;
            $this->houseId = self::$id;
        }

        public function __destruct()
        {
            echo "<h5>Destructor #" . $this->houseId . "</h5>";
        }

        public function EditHomeSize($newWidth, $newHeight, $newFloors = 0)
        {
            $this->width = $newWidth;
            $this->height = $newHeight;
            if ($newFloors != 0)
                $this->floors = $newFloors;
        }

        public function DisplayInfo()
        {
            echo '<p>';
            echo $this->GetInfo();
            echo '</p>';
        }

        public function GetInfo()
        {
            $info = "Home #" . $this->houseId . ":" . '<br>' . "Width: $this->width, Height: $this->height" . '<br>'
                . "Floors: $this->floors, Residents: $this->residents" . '<br>';

            return $info;
        }
    }

    $h1 = new House(200, 100, 10, 500);
    $h1->DisplayInfo();

    $h2 = new House(300, 200, 5, 300);
    $h2->DisplayInfo();

    $bmw1 = new BMW("BMW", 120, "Black", "M5");
    $bmw2 = new BMW("BMW", 120, "Black", "M5");
    $bmw1->Display();
    $bmw2->Display();

    /*

    Output:

    Home #1:
    Width: 200, Height: 100
    Floors: 10, Residents: 500

    Home #2:
    Width: 300, Height: 200
    Floors: 5, Residents: 300

    Welcome to the BMW auto!Welcome to the BMW auto!
    Car #1
    Name: M5; Model: BMW; Color: Black; Speed: 120
    Car #2
    Name: M5; Model: BMW; Color: Black; Speed: 120
    Destructor #2
    Destructor #1

    */
    ?>
</body>

</html>