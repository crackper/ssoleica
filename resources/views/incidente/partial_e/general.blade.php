<div class="row" style="padding: 15px 15px 10px 15px;">
            <div class="col-sm-6">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="proyecto_id" class="form-label col-sm-4">Proyecto</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" readonly="readonly" value="{{ $incidente->contrato->operacion->nombre_operacion  }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contrato_id" class="form-label col-sm-4">Contrato</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" readonly="readonly" value="{{ $incidente->contrato->nombre_contrato  }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tipo_informe" class="form-label col-sm-4">Tipo Informe</label>
                        <div class="col-sm-8">
                            {!! Form::select('tipo_informe',$tipo_informe,old('tipo_informe_id') ? old('tipo_informe_id') : $incidente->tipo_informe_id,array('id'=> 'tipo_informe', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                            </div>

                    </div>
                    <div class="form-group">
                        <label for="tipo_incidente" class="form-label col-sm-4">Tipo Incidente</label>
                        <div class="col-sm-8">
                            {!! Form::select('tipo_incidente',$tipo_incidente,old('tipo_incidente_id') ? old('tipo_incidente_id') : $incidente->tipo_incidente_id,array('id'=> 'tipo_incidente', 'class' => 'form-control input-sm','data-toggle' => 'select')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="form-label col-sm-4">Fecha y Hora</label>
                        <div class="col-sm-8">
                            <input type="hidden" id="fecha_i" name="fecha_i" value="{{ old('fecha') ? old('fecha') : $incidente->fecha }}"/>
                            <input type='text' class="form-control input-sm" id='fecha' name="fecha" value="{{ old('fecha') ? old('fecha') : $incidente->fecha }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lugar" class="form-label col-sm-4">Lugar del Suceso</label>
                        <div class="col-sm-8">
                            <input type="text" id="lugar" name="lugar" class="form-control input-sm" value="{{ old('lugar') ? old('lugar') : $incidente->lugar }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="punto" class="form-label col-sm-4">Punto Especifico</label>
                        <div class="col-sm-8">
                            <input type="text" id="punto" name="punto" class="form-control input-sm" value="{{ old('punto') ? old('punto') : $incidente->punto }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="equipos" class="form-label col-sm-4">Equipo(s) Afectado(s)</label>
                        <div class="col-sm-8">
                            <input type="text" id="equipos" name="equipos" class="form-control input-sm" value="{{ old('equipos') ? old('equipos') : $incidente->equipos }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parte" class="form-label col-sm-4">Parte</label>
                        <div class="col-sm-8">
                            <input type="text" id="parte" name="parte" class="form-control input-sm" value="{{ old('parte') ? old('parte') : $incidente->parte }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sector" class="form-label col-sm-4">Sector</label>
                        <div class="col-sm-8">
                            <input type="text" id="sector" name="sector" class="form-control input-sm" value="{{ old('sector') ? old('sector') : $incidente->sector }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="responsable" class="form-label col-sm-4">Jefe Responsable</label>
                        <div class="col-sm-8">
                            {!! Form::select('responsables',$trabajadores,old('responsable_id') ? old('responsable_id') : $incidente->responsable_id,array('id'=> 'responsables', 'class' => 'form-control input-sm','data-live-search'=>'true','data-toggle' => 'select')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="listAfectados" data-url="/incidente/trabajadorcargo/">Trabajadores Afectados</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" id="btnRemoveAfectados" class="btn btn-box-tool" data-toggle="tooltip" title="Quitar Trabajadores" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul id="ulAfectados" class="nav nav-pills nav-stacked">
                    @foreach($incidente->afectados as $key => $afectado)
                         <li>
                            <!--hidden-->
                            <input type="hidden" name="trbAfectado[]" value="{{ $afectado->trabajador_id  }}"/>
                            <!--hidden-->
                            <a data-toggle="collapse" data-target="#{{ $afectado->dni  }}" aria-expanded="false" aria-controls="{{ $afectado->dni  }}">
                                <i class="fa fa-caret-right"></i> {{ $afectado->trabajador }}
                                <input type="checkbox" name="removeAfectado[]" class="pull-right" value="{{ $afectado->trabajador_id  }}"/>
                            </a>
                            <div class="collapse" id="{{ $afectado->dni }}">
                                <div class="" style="padding: 5px 5px 5px 5px;">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class=""><b>RUT/DNI:</b> {{ $afectado->dni }}</li>
                                        <li class=""><b>Cargo:</b> {{ $afectado->cargo }}</li>
                                        <li class=""><b>Antiguedad Cargo:</b> {{ \Carbon\Carbon::parse($afectado->fecha_cargo)->format('d/m/Y') }}</li>
                                        <li class=""><b>Antiguedad Empresa:</b> {{ \Carbon\Carbon::parse($afectado->fecha_ingreso)->format('d/m/Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                         </li>
                    @endforeach
                    </ul>
                  </div>
                  <div class="box-footer">
                    <div class="form-horizontal">
                        <div class="input-group">
                          <div class="col-sm-10">
                            <input id="trbAfectados" placeholder="Apellidos o Nombres ..." class="form-control autocompleter" type="text">
                          </div>
                          <button type="button" id="btnAddAfectado" class="btn btn-danger btn-flat" data-loading-text="Agregando...">Agregar</button>
                        </div>
                    </div>
                  </div><!-- /.box-footer-->
                </div>
                <div class="box box-warning">
                   <div class="box-header with-border">
                    <h3 class="box-title" id="listInvolucrados" data-url="/incidente/trabajadorcargo/">Trabajadores Involucrados</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" id="btnRemoveInvolucrados" class="btn btn-box-tool" data-toggle="tooltip" title="Quitar Trabajadores" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul id="ulInvolucrados" class="nav nav-pills nav-stacked">
                        @foreach($incidente->involucrados as $key => $involucrado )
                         <li>
                            <!--hidden-->
                            <input type="hidden" name="trbInvolucrado[]" value="{{ $involucrado->trabajador_id }}"/>
                            <!--hidden-->
                            <a data-toggle="collapse" data-target="#{{ $involucrado->dni.'_'.$rand = rand(0,9999) }}" aria-expanded="false" aria-controls="[!{dni}!]">
                                <i class="fa fa-caret-right"></i> {{  $involucrado->trabajador}}
                                <input type="checkbox" name="removeInvolucrado[]" class="pull-right" value="{{ $involucrado->trabajador_id }}"/>
                            </a>
                            <div class="collapse" id="{{$involucrado->dni.'_'.$rand  }}">
                                <div class="" style="padding: 5px 5px 5px 5px;">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class=""><b>RUT/DNI:</b> {{ $involucrado->dni  }}</li>
                                        <li class=""><b>Cargo:</b> {{ $involucrado->cargo }}</li>
                                        <li class=""><b>Antiguedad Cargo:</b> {{ \Carbon\Carbon::parse($involucrado->fecha_cargo)->format('d/m/Y') }}</li>
                                        <li class=""><b>Antiguedad Empresa:</b> {{ \Carbon\Carbon::parse($involucrado->fecha_ingreso)->format('d/m/Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                         </li>
                         @endforeach
                    </ul>
                  </div>
                  <div class="box-footer">
                    <div class="form-horizontal">
                        <div class="input-group">
                          <div class="col-sm-10">
                            <input id="trbInvolucrados" placeholder="Apellidos o Nombres ..." class="form-control autocompleter" type="text">
                          </div>
                          <button type="button" id="btnAddInvolucrado" class="btn btn-warning btn-flat" data-loading-text="Agregando...">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>