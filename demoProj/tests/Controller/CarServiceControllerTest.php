<?php
/**
 * Created by PhpStorm.
 * User: Marius
 * Date: 01/12/2019
 * Time: 23:45
 */

namespace App\Tests\Controller;


use App\Controller\CarServicesController;
use App\Entity\Repair;
use PHPUnit\Framework\TestCase;

class CarServiceControllerTest extends TestCase
{
    public function testsetRepairDoneTest(){
        $carService = new CarServicesController();
        $repair = new Repair();
        $carService->setRepairDone($repair);
        $this->assertEquals($repair->getIsDone(), true);
    }
}