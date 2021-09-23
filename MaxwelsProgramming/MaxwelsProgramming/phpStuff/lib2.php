<?php


namespace Lib2;


include "lib1.php";



class Hund {
        public $vorname;

        public $nachname;
    
        public $basicDog;


        public function __construct() {
            $basicDog = new \Lib1\Hund();
        }

        public function laufen() {
            echo("Hallo");
        }
    
        public function laut() {
            echo ("Wuff!");
        }
    
        public function spielen($spieler) {
            ($spieler)();
        }
}