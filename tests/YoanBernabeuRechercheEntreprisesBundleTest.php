<?php

namespace YoanBernabeu\RechercheEntreprisesBundle\Tests;

use PHPUnit\Framework\TestCase;
use YoanBernabeu\RechercheEntreprisesBundle\YoanBernabeuRechercheEntreprisesBundle;

class YoanBernabeuRechercheEntreprisesBundleTest extends TestCase
{
    public function testBundleCanBeInstantiated(): void
    {
        $bundle = new YoanBernabeuRechercheEntreprisesBundle();
        $this->assertInstanceOf(YoanBernabeuRechercheEntreprisesBundle::class, $bundle);
    }

    public function testGetPath(): void
    {
        $bundle = new YoanBernabeuRechercheEntreprisesBundle();
        $path = $bundle->getPath();

        $this->assertDirectoryExists($path);
    }
}
