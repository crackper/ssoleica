<?php
use \SSOLeica\Core\Model\Trabajador;
use \SSOLeica\Core\Repository\TrabajadorRepository;
use \Illuminate\Contracts\Container;

class TrabajadorRepositoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @var
     */
    private $trabajadorRepository;

    public function __construct(TrabajadorRepository $trabajadorRepository){

        $this->trabajadorRepository = $trabajadorRepository;
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $trabajador = array();

        $trabajador['pais_id'] = 8;
        $trabajador['dni'] = '12345678';
        $trabajador['nombre'] = 'Samuel';
        $trabajador['app_paterno'] = 'Mestanza';
        $trabajador['app_materno'] = 'A.';
        $trabajador['sexo'] = 'M';
        $trabajador['fecha_nacimiento'] = '1981-10-24';
        $trabajador['estado_civil'] = 'Casado';
        $trabajador['direccion'] = 'Urb. San Roque, El Capuli A-02';
        $trabajador['fecha_ingreso'] = '2014-11-23';
        $trabajador['profesion_id'] = 5;
        $trabajador['cargo_id'] = 5;

        $this->trabajadorRepository->create($trabajador);

        $this->assertEquals('Samuel',$trabajador['nombre']);
    }

}