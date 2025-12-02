<section class="py-4 px-4 depth-2">
    <h2>Listado de Incidentes de Estudiantes</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Estudiante</th>
                <th>Fecha Incidente</th>
                <th>Tipo</th>
                <th>Descripcion</th>
                <th>Accion Tomada</th>
                <th>Estado</th>
                <th><a href="index.php?page=Incidentes-IncidentesEstudiante&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach incidentes_estudiantiles}}
            <tr>
                <td>{{id}}</td>
                <td>{{estudiante_nombre}}</td>
                <td>{{fecha_incidente}}</td>
                <td>{{tipo_incidente}}</td>
                <td>{{descripcion}}</td>
                <td>{{accion_tomada}}</td>
                <td>{{estado}}</td>
                <td>
                    <a href="index.php?page=Incidentes-IncidentesEstudiante&mode=UPD&id={{id}}">Editar</a>&nbsp;
                    <a href="index.php?page=Incidentes-IncidentesEstudiante&mode=DEL&id={{id}}">Eliminar</a>&nbsp;
                    <a href="index.php?page=Incidentes-IncidentesEstudiante&mode=DSP&id={{id}}">Ver</a>
                </td>
            </tr>
            {{endfor incidentes_estudiantiles}}
        </tbody>
    </table>
</section>
