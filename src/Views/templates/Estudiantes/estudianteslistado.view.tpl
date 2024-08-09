<h2>Listado de Estudiantes</h2>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Especialidad</th>
                <th>
                    <a href="index.php?page=Estudiantes_EstudiantesForm&mode=INS" class="btn">
                        Nuevo
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach estudiantescienciascomputacionales}}
            <tr>
                <td>{{id_estudiante}}</td>
                <td>{{nombre}}</td>
                <td>{{apellido}}</td>
                <td>{{edad}}</td>
                <td>{{especialidad}}</td>
                <td>
                    <a href="index.php?page=Estudiantes_EstudiantesForm&mode=DSP&id_estudiante={{id_estudiante}}">
                        Ver
                    </a>&nbsp;
                    <a href="index.php?page=Estudiantes_EstudiantesForm&mode=UPD&id_estudiante={{id_estudiante}}">
                        Editar
                    </a>&nbsp;
                    <a href="index.php?page=Estudiantes_EstudiantesForm&mode=DEL&id_estudiante={{id_estudiante}}">
                        Eliminar
                    </a>&nbsp;
                </td>
            </tr>
            {{endfor estudiantescienciascomputacionales}}
        </tbody>
    </table>
</section>