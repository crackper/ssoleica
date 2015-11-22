<?php namespace SSOLeica\Http\Controllers;



use Pqb\FilemanagerLaravel\FilemanagerLaravel;

class FilemanagerLaravelController extends Controller {
	public function __construct(){
		$this->middleware('auth');
		
	}
	public function getShow()
	{
		return view('filemanager-laravel::filemanager.index');
	}

    public function getRepository()
    {
        return view('filemanager-laravel::filemanager.repository');
    }

	public function getConnectors()
	{
		$f = FilemanagerLaravel::Filemanager();
        $f->connector_url = url('/').env('URL_CONNECTOR', '/connectors');
		$f->run();
	}
	public function postConnectors()
	{
		$f = FilemanagerLaravel::Filemanager();
        $f->connector_url = url('/').env('URL_CONNECTOR', '/connectors');
		$f->run();
	}

}
