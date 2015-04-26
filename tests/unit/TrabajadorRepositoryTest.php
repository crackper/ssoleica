<?php


class TrabajadorRepositoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $trabajador = new \SSOLeica\Core\Model\Trabajador();

        $trabajador->dni = '12345678';
        $trabajador->nombre = 'Samuel';
        $trabajador->apellidos = 'Mestanza';
        $trabajador->fecha_nacimiento = '1981-10-24';
        $trabajador->estado_civil = 'Casado';
        $trabajador->direccion = 'Urb. San Roque, El Capuli A-02';
        $trabajador->fecha_ingres = '2014-11-23';
        $trabajador->profesion_id = 5;
        $trabajador->cargo_id = 5;
        $trabajador->save();

        $this->assertEquals('Samuel',$trabajador->nombre);
    }

}