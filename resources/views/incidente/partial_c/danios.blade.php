<div class="row" style="padding: 0px 10px 0px 10px;">
    <div class="col-sm-12">
        <h1 class="page-header">Daños Materiales</h1>
        <div class="form-inline">
            <div class="form-group">
                <label for="d_materiales">Entidad Siniestrada</label>
                @foreach($entidades as $key => $entidad)
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('d_materiales[]', $key,   false )  !!} {{ $entidad }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="padding: 10px 0px 0px 0px; ">
            <div class="form-group">
                <label for="danios_mat">Equipo / Maquina / Herramienta / Instalación afectado</label>
                <textarea name="danios_mat" class="form-control" id="danios_mat" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="desc_danios_mat">Descripción de los daños</label>
                <textarea name="desc_danios_mat" class="form-control" id="desc_danios_mat" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding: 0px 10px 0px 10px;">
    <div class="col-sm-12">
        <h1 class="page-header">Daños Ambientales</h1>
        <div class="form-inline">
            <div class="form-group">
                <label for="d_ambientales">Entidad Siniestrada</label>
                @foreach($entidades as $key => $entidad)
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('d_ambientales[]', $key,   false )  !!} {{ $entidad }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="padding: 10px 0px 0px 0px; ">
            <div class="form-group">
                <label for="danios_amb">Lugar afectado:</label>
                <textarea name="danios_amb" class="form-control" id="danios_amb" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="desc_danios_mat">Descripción de los daños</label>
                <textarea name="desc_danios_amb" class="form-control" id="desc_danios_amb" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
</div>