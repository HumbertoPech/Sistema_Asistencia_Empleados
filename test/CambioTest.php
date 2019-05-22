<?php
use PHPUnit\Framework\TestCase;
use Cambio;

final class CambioTest extends TestCase
{
    public function testNuevoPassword(){
      require "CambioPassword.php";
      $cambiar=new Cambio();
      
      $this->assertEquals(  
         
         true,$cambiar->cambioPassword(19,951848,147896)
      );
    }
}
?>