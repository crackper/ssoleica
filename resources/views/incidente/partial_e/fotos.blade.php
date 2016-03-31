<div class="row" style="padding: 15px 15px 10px 15px;">
    <div id="progress" class="progress" style="height: 5px;">
        <div class="progress-bar progress-bar-success" style="height: 5px;"></div>
    </div>
<span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Agregar Fotos...</span>
        <span>Seleccionar...</span>
        <input id="foto" type="file" name="fotos[]" accept="image/*"  multiple data-url="/incidente/upload-fotos/{{ $incidente->id  }}" >
    </span>
    <br>
    <div id="files" class="files" style="padding: 10px 5px 5px 10px;"></div>
</div>

<section id="least">
<div class="least-preview"></div>
    <ul class="least-gallery">
       @foreach($incidente->fotos as $foto)
        <li id="{{ $foto['id']  }}">
            <a href="{{ url($foto['fullPath']) }}" title="SSOLeica" data-subtitle="Ver Imagen"
            data-caption="<button type='button' class='btn btn-primary delete' data-url='/incidente/delete-image/{{ $foto['id'] }}' data-id='{{ $foto['id']  }}' ><span class='fa fa-trash-o'/> Eliminar</button>">
                <img src="{{ url($foto['fullPathTumb']) }}" alt="SSOLeica" />
            </a>
        </li>
        @endforeach
    </ul>
</section>