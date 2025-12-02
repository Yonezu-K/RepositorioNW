<section class="py-4 px-4 depth-2">
    <h2>Listado de Roles</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Roles</th>
                <th>Estado</th>
                <th><a href="index.php?page=Administracion-Rol&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach roles}}
            <tr>
                <td>{{rolescod}}</td>
                <td>{{rolesdsc}}</td>
                <td>{{rolesest}}</td>
                <td>
                    <a href="index.php?page=Administracion-Rol&mode=UPD&id={{rolescod}}">Editar</a>&nbsp;
                    <a href="index.php?page=Administracion-Rol&mode=DEL&id={{rolescod}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=Administracion-Rol&mode=DSP&id={{rolescod}}">Ver</a>
                </td>
            </tr>
            {{endfor roles}}
        </tbody>
    </table>
</section>