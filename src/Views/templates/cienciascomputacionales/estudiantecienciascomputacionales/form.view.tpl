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
    <form action="index.php?page=CienciasComputacionales-EstudianteCienciasComputacional&mode={{mode}}&id_estudiante={{id_estudiante}}" method="POST">
        <div>
            <label for="id_estudiante">ID Estudiante</label>
            <input type="number" name="id_estudiante" id="id_estudiante" value="{{id_estudiante}}" {{id_estudianteReadonly}}/>
            <input type="hidden" name="vlt" value="{{token}}" />
        </div>
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{nombre}}" {{readonly}}/>
        </div>
        <div>
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{apellido}}" {{readonly}}/>
        </div>
        <div>
            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" value="{{edad}}" {{readonly}}/>
        </div>
        <div>
            <label for="especialidad">Especialidad</label>
            <input type="text" name="especialidad" id="especialidad" value="{{especialidad}}" {{readonly}}/>
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
            window.location.assign("index.php?page=CienciasComputacionales-EstudianteCienciasComputacionales");
        })
    });
</script>
