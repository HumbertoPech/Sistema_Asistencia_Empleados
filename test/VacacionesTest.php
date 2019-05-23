<?php
use PHPUnit\Framework\TestCase;
use Vacaciones;

final class VacacionesTest extends TestCase
{
    public function testNuevoPassword(){
      require "Vacaciones.php";
      $vacacion=new Vacaciones();
      
      $this->assertEquals(  
         
         true,$vacacion->agregar(19,'22-05-2019','27-05-2019')
      );
    }
}
?>