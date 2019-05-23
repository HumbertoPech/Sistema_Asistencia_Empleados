<?php
use PHPUnit\Framework\TestCase;
use Horas;

final class HorasTest extends TestCase
{
    public function testHoras(){
      require "Horas.php";
      $horas=new Horas();
      
      $this->assertEquals(  
         
         true,$horas->calcular(19,'2019-05-22')
      );
    }
}
?>