<script id="afectado-template" type="text/x-handlebars-template">
 <li>
    <a data-toggle="collapse" data-target="#[{dni}]" aria-expanded="false" aria-controls="[{dni}]">
        <i class="fa fa-caret-right"></i> [{trabajador}]
        <button type="button" class="label btn btn-box-tool pull-right" data-toggle="tooltip" title="Quitar Trabajador" data-widget="chat-pane-toggle"><i class="fa fa-user-times"></i> </button>
    </a>
    <div class="collapse" id="[{dni}]">
        <div class="" style="padding: 5px 5px 0px 5px;">
            <ul class="list-group">
                <li class="list-group-item"><b>RUT/DNI:</b> [{dni}]</li>
                <li class="list-group-item"><b>Cargo:</b> [{cargo}]</li>
                <li class="list-group-item"><b>Antiguedad Cargo:</b> [{fecha_cargo}]</li>
                <li class="list-group-item"><b>Antiguedad Empresa:</b> [{fecha_ingreso}]</li>
            </ul>
        </div>
    </div>
 </li>
</script>