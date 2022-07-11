<?php 

declare(strict_types=1);

class Pont
{

    private const SURFACE_TEXT = 'Ce pont mesure %dm';
    // private string $unite = 'm²';

    private float $longueur;
    private float $largeur;
    private float $hauteur;

    public function setLongueur(float $longueur): void
    {
        if ($longueur < 0) {
            trigger_error(
                'La longueur est trop courte. (min 1)',
                E_USER_ERROR
            );
        }

        $this->longueur = $longueur;

    }

    public function getLongueur(): float 
    {
        return $this->longueur;
    }

    public function setLargeur(float $largeur): void
    {
        if ($largeur < 0) {
            trigger_error(
                'La largeur est trop courte. (min 1)',
                E_USER_ERROR
            );
        }

        $this->largeur = $largeur;

    }

    public function getLargeur(): float 
    {
        return $this->largeur;
    }


    public function setHauteur(float $hauteur): void
    {
        if ($hauteur < 0) {
            trigger_error(
                'La hauteur est trop courte. (min 1)',
                E_USER_ERROR
            );
        }

        $this->hauteur = $hauteur;

    }

    public function getHauteur(): float 
    {
        return $this->hauteur;
    }


    public function getSurface(): float
    {
        return $this->longueur * $this->largeur * $this->hauteur;
    }

    public function printSurface(): void
    {
        echo sprintf(self::SURFACE_TEXT, $this->getSurface());
    }
}

$towerBridge = new Pont;
$towerBridge->setLongueur(20);
$towerBridge->setLargeur(5);
$towerBridge->setHauteur(10);
// $towerBridge->largeur = 2;
// $towerBridge->hauteur = 2;

// $manhattanBridge = new Pont;
// $manhattanBridge->longueur = 4;
// $manhattanBridge->largeur = 4;
// $manhattanBridge->hauteur = 4;

// $towerBridgeSurface = $towerBridge->getSurface();
// $manhattanBridgeSurface = $manhattanBridge->getSurface();

$towerBridge->printSurface();

// $surface = $pont->longueur * $pont->largeur * $pont->hauteur;
// echo '<pre>';
// var_dump($manhattanBridgeSurface);
// var_dump($towerBridgeSurface);
// echo '</pre>';



