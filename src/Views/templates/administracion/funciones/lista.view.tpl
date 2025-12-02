<section class="py-4 px-4 depth-2">
    <h2>Listado de Funciones</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Funcion</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th><a href="index.php?page=Administracion-Funcion&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach funciones}}
            <tr>
                <td>{{fncod}}</td>
                <td>{{fndsc}}</td>
                <td>{{fnest}}</td>
                <td>{{fntyp}}</td>
                <td>
                    <a href="index.php?page=Administracion-Funcion&mode=UPD&fncod={{fncod}}">Editar</a>&nbsp;
                    <a href="index.php?page=Administracion-Funcion&mode=DEL&id={{fncod}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=Administracion-Funcion&mode=DSP&id={{fncod}}">Ver</a>
                </td>
            </tr>
            {{endfor funciones}}
        </tbody>
    </table>
</section>