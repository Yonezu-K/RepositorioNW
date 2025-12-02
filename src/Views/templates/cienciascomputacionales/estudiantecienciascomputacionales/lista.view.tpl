<section class="py-4 px-4 depth-2">
    <h2>Listado de Estudiantes de Ciencias Computacionales</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Estudiante</th>
                <th>Apellido del Estudiante</th>
                <th>Edad</th>
                <th>Especialidad</th>
                <th><a href="index.php?page=CienciasComputacionales-EstudianteCienciasComputacional&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach EstudianteCienciasComputacionales}}
            <tr>
                <td>{{id_estudiante}}</td>
                <td>{{nombre}}</td>
                <td>{{apellido}}</td>
                <td>{{edad}}</td>
                <td>{{especialidad}}</td>
                <td>
                    <a href="index.php?page=CienciasComputacionales-EstudianteCienciasComputacional&mode=UPD&id_estudiante={{id_estudiante}}">Editar</a>&nbsp;
                    <a href="index.php?page=CienciasComputacionales-EstudianteCienciasComputacional&mode=DEL&id_estudiante={{id_estudiante}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=CienciasComputacionales-EstudianteCienciasComputacional&mode=DSP&id_estudiante={{id_estudiante}}">Ver</a>
                </td>
            </tr>
            {{endfor EstudianteCienciasComputacionales}}
        </tbody>
    </table>
</section>
