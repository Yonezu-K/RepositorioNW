<section class="py-4 px-4 depth-2">
    <h2>Listado de Usuarios</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Email</th>
                <th>Nombre</th>
                <th>Fecha de Creación</th>
                <th>Fecha de Expiración</th>
                <th>Estado Usuario</th>
                <th>Tipo de Usuario</th>
                <th><a href="index.php?page=Administracion-Usuario&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach usuarios}}
            <tr>
                <td>{{usercod}}</td>
                <td>{{useremail}}</td>
                <td>{{username}}</td>
                <td>{{userfching}}</td>
                <td>{{userpswdexp}}</td>
                <td>{{userest}}</td>
                <td>{{usertipo}}</td>
                <td>
                    <a href="index.php?page=Administracion-Usuario&mode=UPD&id={{usercod}}">Editar</a>&nbsp;
                    <a href="index.php?page=Administracion-Usuario&mode=DEL&id={{usercod}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=Administracion-Usuario&mode=DSP&id={{usercod}}">Ver</a>
                </td>
            </tr>
            {{endfor usuarios}}
        </tbody>
    </table>
</section>
