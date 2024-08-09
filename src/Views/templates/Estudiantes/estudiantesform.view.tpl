<h2>{{modeDesc}}</h2>
<section>
    <form action="index.php?page=Estudiantes_EstudiantesForm&mode={{mode}}&id_estudiante={{id_estudiante}}" method="post">
        <input type="hidden" name="id_estudiante" value="{{id_estudiante}}">
        <input type="hidden" name="token" value="{{~estudiante_xss_token}}" />
        <div class="row">
        <label for="category_id">ID</label>
        <input type="text" name="id_estudiante" id="id_estudiante" value="{{id_estudiante}}" disabled>
        </div>&nbsp;
        <div class="row">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{nombre}}">
        </div>&nbsp;
        <div class="row">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="{{apellido}}">
        </div>&nbsp;
        <div class="row">
            <label for="edad">Edad</label>
            <input type="text" name="edad" id="edad" value="{{edad}}">
        </div>&nbsp;
        <div class="row">
            <label for="edad">Especialidad</label>
            <input type="text" name="edad" id="edad" value="{{especialidad}}">
        </div>&nbsp;
        <div class="row">
            <button type="submit" name="btnGuardar" id="btnGuardar">Guardar</button>
            &nbsp;
            <button name="btnCancelar" id="btnCancelar">Cancelar</button>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const btnCancelar = document.getElementById('btnCancelar');
        btnCancelar.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            window.location.href = 'index.php?page=Estudiantes_EstudiantesListado';
        });
    });
</script>