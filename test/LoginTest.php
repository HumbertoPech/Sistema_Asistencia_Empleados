<?php
use PHPUnit\Framework\TestCase;
use Inicio;

final class LoginTest extends TestCase
{
    public function testLogin(){
      require "Inicio.php";
      $login=new Inicio();
      $this->assertEquals(  
         true,$login->entrar("fernandolopez4610","951848")
      );
    }

}
?>