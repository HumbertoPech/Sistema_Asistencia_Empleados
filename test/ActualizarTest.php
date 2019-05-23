<?php
use PHPUnit\Framework\TestCase;
use Actualizar;

final class ActualizarTest extends TestCase
{
    public function testActualizar(){
      require "Actualizar.php";
      $actualiza=new Actualizar();
      $datos_entrada=array(19, "Fernando Jose", "Perez Sanchez",
      3500, "Calle 39 # 318", "Hombre","Casado","FEGA980991929HAS");
      $this->assertEquals(  
         true,$actualiza->actualizar($datos_entrada)
      );
    }
}
?>