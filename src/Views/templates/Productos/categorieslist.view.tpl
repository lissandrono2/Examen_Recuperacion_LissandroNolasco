<h2>Listado de Categorías</h2>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Status</th>
                <th>
                    {{if categories_new_enabled}}
                    <a href="index.php?page=Products_CategoryForm&mode=INS" class="btn">
                        Nuevo
                    </a>
                    {{endif categories_new_enabled}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach categories}}
            <tr>
                <td>{{category_id}}</td>
                <td>{{category_name}}</td>
                <td>{{category_status}}</td>
                <td>
                    {{if ~categories_view_enabled}}
                    <a href="index.php?page=Products_CategoryForm&mode=DSP&category_id={{category_id}}">
                        Ver
                    </a>&nbsp;
                    {{endif ~categories_view_enabled}}
                    {{if ~categories_edit_enabled}}
                    <a href="index.php?page=Products_CategoryForm&mode=UPD&category_id={{category_id}}">
                        Editar
                    </a>&nbsp;
                    {{endif ~categories_edit_enabled}}
                    {{if ~categories_delete_enabled}}
                    <a href="index.php?page=Products_CategoryForm&mode=DEL&category_id={{category_id}}">
                        Eliminar
                    </a>&nbsp;
                    {{endif ~categories_delete_enabled}}
                </td>
            </tr>
            {{endfor categories}}
        </tbody>
    </table>
</section>