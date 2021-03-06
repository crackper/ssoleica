<div class="row" style="padding: 0px 10px 0px 10px;">
    <div class="col-sm-12">
        <h1 class="page-header">A las Personas</h1>
        <div class="form-group col-sm-4" style="border-right: 1px #eeeeee solid;">
            <label for="parte">Partes Afectadas</label>
                <div class="row">
                    <div>
                @for($i = 0; $i < count($partes_afectadas); $i++)
                    @if($i % 5 == 0)
                         <!-- abriendo div-->
                        </div>
                        <div class="form-group col-sm-4">
                    @endif
                         <div class="checkbox">
                            <label>
                                {!! Form::checkbox('parte_afectada[]', $partes_afectadas[$i]->id,   false )  !!} {{ $partes_afectadas[$i]->name }}
                            </label>
                          </div>
                    @if($i ==  count($partes_afectadas) - 1)
                        </div>
                    @endif
                @endfor
                </div>

        </div>
        <div class="form-group col-sm-2">
            <label for="entidad">De</label>
                @foreach($entidades as $key => $entidad)
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('entidad[]', $key,   false )  !!} {{ $entidad }}
                        </label>
                    </div>
                @endforeach
        </div>
        <div class="form-group col-sm-3" style="border-left: 1px #eeeeee solid;">
            <label for="consecuencia">Consecuencia</label>
                @foreach($consecuencias as $key => $consecuencia)
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('consecuencia[]', $key,   false )  !!} {{ $consecuencia }}
                        </label>
                      </div>
                @endforeach
        </div>
    </div>
</div>
<div class="row" style="padding: 0px 10px 0px 10px;">
    <div class="col-sm-12">
        <div class="form-inline">
            <div class="form-group">
                <label for="dias_perdidos">Cantidad de días perdidos previsibles</label>
                 <input type="text" id="dias_perdidos" name="dias_perdidos" class="form-control input-sm" value="0" />
                (Indicar solo para personal de LEICA)
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <h1 class="page-header">Consecuencias Posibles</h1>
</div>
<div class="col-sm-12" style="padding: 0px 0px 10px 10px;">
    <textarea name="cons_posibles" class="form-control" id="cons_posibles" cols="30" rows="10"></textarea>
</div>