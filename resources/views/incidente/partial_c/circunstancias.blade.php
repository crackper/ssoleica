<div class="row" style="padding: 0px 10px 0px 10px;">
    <div class="col-sm-12">
        <h1 class="page-header">Circunstancias</h1>
    </div>
    <div class="col-sm-8">
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="jornada_id" class="form-label col-sm-4">Jornada</label>
                    <div class="col-sm-8">
                        {!! Form::select('jornada_id',$jornadas,null,array('id'=> 'jornada_id', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label for="naturaleza" class="form-label col-sm-4">Natrualeza del Hecho (3 palabras)</label>
                    <div class="col-sm-8">
                        <input type="text" id="naturaleza" name="naturaleza" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="actividad" class="form-label col-sm-4">Actividad Desarrollada</label>
                    <div class="col-sm-8">
                        <input type="text" id="actividad" name="actividad" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="equipo" class="form-label col-sm-4">Equipo</label>
                    <div class="col-sm-8">
                        <input type="text" id="equipo" name="equipo" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="parte_equipo" class="form-label col-sm-4">Parte del Equipo</label>
                    <div class="col-sm-8">
                        <input type="text" id="parte_equipo" name="parte_equipo" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lugar" class="form-label col-sm-4">Producto</label>
                    <div class="col-sm-8">
                        <input type="text" id="producto" name="producto" class="form-control input-sm"/>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-sm-12">
        <h1 class="page-header">Descripción de la Situación</h1>
    </div>
    <div class="col-sm-12" style="padding: 0px 0px 10px 10px;">
        <textarea name="des_situacion" class="form-control" id="des_situacion" cols="30" rows="10"></textarea>
    </div>
</div>