<?php


class TrabajadorTest extends \Codeception\TestCase\Test
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
    public function testAddTrabajador()
    {
        $trabajador = new \SSOLeica\Core\Model\Trabajador();

        $trabajador->dni = '12345678';
        $trabajador->nombre = 'Samuel';
        $trabajador->apellidos = 'Mestanza';
        $trabajador->fecha_nacimiento = '1981-10-24';
        $trabajador->estado_civil = 'Casado';
        $trabajador->direccion = 'Urb. San Roque, El Capuli A-02';
        $trabajador->fecha_ingreso = '2014-11-23';
        $trabajador->profesion_id = 5;
        $trabajador->cargo_id = 5;
        $trabajador->save();

        $this->assertTrue($trabajador->id > 0);

    }

}