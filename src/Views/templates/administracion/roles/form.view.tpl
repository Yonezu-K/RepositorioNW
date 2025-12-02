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
    <form action="index.php?page=Administracion-Roles&mode={{mode}}&rolescod={{rolescod}}" method="POST">
        <div>
            <label for="rolescod">Codigo</label>
            <input type="text" name="rolescod" id="rolescod" value="{{rolescod}}" {{rolescodReadonly}}/>
            <input type="hidden" name="vlt" value="{{token}}" />
        </div>
        <div>
            <label for="rolesdsc">Rol</label>
            <input type="text" name="rolesdsc" id="rolesdsc" value="{{rolesdsc}}" {{readonly}}/>
        </div>
        
        <div>
            <label for="rolesest">Estado</label>
            {{ifnot readonly}}
                <select name="rolesest" id="rolesest" >
                    <option value="ACT" {{selectedACT}}>Activo</option>
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}
            {{if readonly}}
                <input type="text" name="rolesest" id="rolesest" value="{{rolesest}}" {{readonly}}/>
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
            window.location.assign("index.php?page=Administracion-Roles");
        })
    });
</script>
