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
    <form action="index.php?page=Administracion-Usuario&mode={{mode}}&usercod={{usercod}}" method="POST">
        <div>
            <label for="usercod">Codigo</label>
            <input type="number" name="usercod" id="usercod" value="{{usercod}}" {{usercodReadonly}}/>
            <input type="hidden" name="vlt" value="{{token}}" />
        </div>
        <div>
            <label for="useremail">Email</label>
            <input type="text" name="useremail" id="useremail" value="{{useremail}}" {{readonly}}/>
        </div>
        <div>
            <label for="username">Nombre</label>
            <input type="text" name="username" id="username" value="{{username}}" {{readonly}}/>
        </div>
        <div>
            <label for="userpswd">Contraseña</label>
            <input type="password" name="userpswd" id="userpswd" value="{{userpswd}}" {{readonly}}/>
        </div>
        <div>
            <label for="userfching">Fecha de ingreso</label>
            <input type="date" name="userfching" id="userfching" value="{{userfching}}" {{readonly}}/>
        </div>
        <div>
            <label for="userpswdexp">Fecha de expiacion</label>
            <input type="date" name="userpswdexp" id="userpswdexp" value="{{userpswdexp}}" {{readonly}}/>
        </div>
        <div>
            <label for="usertipo">Tipo de Usuario</label>
            <input type="text" name="usertipo" id="usertipo" value="{{usertipo}}" {{readonly}}/>
        </div>
        <div>
            <label for="userest">Estado</label>
            {{ifnot readonly}}
                <select name="userest" id="userest" >
                    <option value="ACT" {{selectedACT}}>Activo</option>
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}
            {{if readonly}}
                <input type="text" name="userest" id="userest" value="{{userest}}" {{readonly}}/>
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
            window.location.assign("index.php?page=Administracion-Usuarios");
        })
    });
</script>
