<script id="afectado-template" type="text/x-handlebars-template">
 <li>
    <!--hidden-->
    <input type="hidden" name="trbAfectado[]" value="[!{trabajador_id}!]"/>
    <!--hidden-->
    <a data-toggle="collapse" data-target="#[!{dni}!]" aria-expanded="false" aria-controls="[!{dni}!]">
        <i class="fa fa-caret-right"></i> [!{trabajador}!]
        <input type="checkbox" name="removeAfectado[]" class="pull-right" value="[!{trabajador_id}!]"/>
    </a>
    <div class="collapse" id="[!{dni}!]">
        <div class="" style="padding: 5px 5px 5px 5px;">
            <ul class="nav nav-pills nav-stacked">
                <li class=""><b>RUT/DNI:</b> [!{dni}!]</li>
                <li class=""><b>Cargo:</b> [!{cargo}!]</li>
                <li class=""><b>Antiguedad Cargo:</b> [!{fecha_cargo}!]</li>
                <li class=""><b>Antiguedad Empresa:</b> [!{fecha_ingreso}!]</li>
            </ul>
        </div>
    </div>
 </li>
</script>

<script id="involucrado-template" type="text/x-handlebars-template">
 <li>
    <!--hidden-->
    <input type="hidden" name="trbInvolucrado[]" value="[!{trabajador_id}!]"/>
    <!--hidden-->
    <a data-toggle="collapse" data-target="#[!{dni}!]_{{ $rand = rand(0,9999) }}" aria-expanded="false" aria-controls="[!{dni}!]">
        <i class="fa fa-caret-right"></i> [!{trabajador}!]
        <input type="checkbox" name="removeInvolucrado[]" class="pull-right" value="[!{trabajador_id}!]"/>
    </a>
    <div class="collapse" id="[!{dni}!]_{{ $rand  }}">
        <div class="" style="padding: 5px 5px 5px 5px;">
            <ul class="nav nav-pills nav-stacked">
                <li class=""><b>RUT/DNI:</b> [!{dni}!]</li>
                <li class=""><b>Cargo:</b> [!{cargo}!]</li>
                <li class=""><b>Antiguedad Cargo:</b> [!{fecha_cargo}!]</li>
                <li class=""><b>Antiguedad Empresa:</b> [!{fecha_ingreso}!]</li>
            </ul>
        </div>
    </div>
 </li>
</script>