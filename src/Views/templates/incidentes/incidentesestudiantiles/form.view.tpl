<section class="container">
    <section class="deplth-2">
        <h2>{{mode}}</h2>
    </section>
    {{if hasErrors}}
        <ul class="error">
        {{foreach errores}}
            <li>{{this}}</li>
        {{endfor errores}}
        </ul>
    {{endif hasErrors}}
    <form action="index.php?page=Incidentes-IncidentesEstudiante&mode={{mode}}&id={{id}}" method="POST">
        <div>
            <label for="id">id</label>
            <input type="hidden" name="id" id="id" value="{{id}}" {{idReadonly}}/>
            <input type="hidden" name="vlt" value="{{token}}" />
        </div>
        <div>
            <label for="estudiante_nombre">Estudiante</label>
            <input type="text" name="estudiante_nombre" id="estudiante_nombre" value="{{estudiante_nombre}}" {{readonly}}/>
        </div>
        <div>
            <label for="fecha_incidente">Fecha Incidente</label>
            <input type="date" name="fecha_incidente" id="fecha_incidente" value="{{fecha_incidente}}" {{readonly}}/>
        </div>
        <div>
            <label for="tipo_incidente">Tipo</label>
            <input type="text" name="tipo_incidente" id="tipo_incidente" value="{{tipo_incidente}}" {{readonly}}/>
        </div>
        <div>
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" value="{{descripcion}}" {{readonly}}/>
        </div>
        <div>
            <label for="accion_tomada">Accion Tomada</label>
            <input type="text" name="accion_tomada" id="accion_tomada" value="{{accion_tomada}}" {{readonly}}/>
        </div>
        <div>
            <label for="estado">Estado</label>
            {{ifnot readonly}}
                <select name="estado" id="estado" >
                    <option value="Activo" {{selectedACT}}>Activo</option>
                    <option value="Inactivo" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}
            {{if readonly}}
                <input type="text" name="estado" id="estado" value="{{estado}}" {{readonly}}/>
            {{endif readonly}}
        </div>
        <div>
            <button id="btnCancelar">Cancelar</button>
            {{ifnot isDisplay}}
                <button id="btnConfirmar" type="submit">Confirmar</button>
            {{endifnot isDisplay}}
        </div>
    </form>
</section>
<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancelar").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopImmediatePropagation();
            window.location.assign("index.php?page=Incidentes-IncidentesEstudiantiles");
        })
    });
</script>
