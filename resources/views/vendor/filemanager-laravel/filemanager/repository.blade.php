@extends('app')

   @section('pageheader')
      Repositorio de Archivos
   @endsection

  @section('breadcrumb')
      <li class="active">Repository</li>
  @endsection

@section('content')

<link rel="stylesheet" type="text/css" href="scripts/jquery.filetree/jqueryFileTree.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.contextmenu/jquery.contextMenu-1.01.css" />
<link rel="stylesheet" type="text/css" href="styles/repository.css" />
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="styles/ie9.css" />
<![endif]-->
<!--[if lte IE 8]>
<link rel="stylesheet" type="text/css" href="styles/ie8.css" />
<![endif]-->

<div>
<form id="uploader" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<button id="home" name="home" type="button" value="Home">&nbsp;</button>
    <h1></h1>
    @if(Auth::user()->can('upload_file'))
	<div id="uploadresponse"></div>
	<input id="mode" name="mode" type="hidden" value="add" />
	<input id="currentpath" name="currentpath" type="hidden" />
	<div id="file-input-container">
		<div id="alt-fileinput">
			<input id="filepath" name="filepath" type="text" /><button id="browse" name="browse" type="button" value="Browse"></button>
		</div>
		<input	id="newfile" name="newfile" type="file" />
	</div>
	<button id="upload" name="upload" type="submit" value="Upload"></button>
    @endif

	@if(Auth::user()->can('create_folder'))
	    <button id="newfolder" name="newfolder" type="button" value="New Folder"></button>
	@endif

	<button id="grid" class="ON" type="button">&nbsp;</button>
	<button id="list" type="button">&nbsp;</button>
</form>
<div id="splitter">
<div id="filetree"></div>
<div id="fileinfo">
<h1></h1>
</div>
</div>
<form name="search" id="search" method="get">
		<div>
			<input type="text" value="" name="q" id="q" />
			<a id="reset" href="#" class="q-reset"></a>
			<span class="q-inactive"></span>
		</div>
</form>

<ul id="itemOptions" class="contextMenu">
	<li class="select"><a href="#select"></a></li>
	<li class="download"><a href="#download"></a></li>
	<li class="rename"><a href="#rename"></a></li>
	<li class="move"><a href="#move"></a></li>
	<li class="replace"><a href="#replace"></a></li>
	<li class="delete separator"><a href="#delete"></a></li>
</ul>

<!--script type="text/javascript" src="scripts/jquery-1.8.3.min.js"></script-->
<script src="http://code.jquery.com/jquery-migrate-1.1.0.js"></script>
<script type="text/javascript" src="scripts/jquery.form-3.24.js"></script>
<script type="text/javascript" src="scripts/jquery.splitter/jquery.splitter-1.5.1.js"></script>
<script type="text/javascript" src="scripts/jquery.filetree/jqueryFileTree.js"></script>
<script type="text/javascript" src="scripts/jquery.contextmenu/jquery.contextMenu-1.01.js"></script>
<script type="text/javascript" src="scripts/jquery.impromptu-3.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.tablesorter-2.7.2.min.js"></script>
<script type="text/javascript" src="scripts/filemanager.js"></script>

@endsection

@section('scripts')


 @endsection