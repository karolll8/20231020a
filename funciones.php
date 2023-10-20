<?php //se abre php

/**
 * @parametro$u= valor de texto
 * @return= texto
 */




function consultar($u=null, $c=null) //crear una funcion
{
    $salida = ""; // Inicializa la variable
    $conexion = mysqli_connect("localhost", "root", "root", "RUBLE_FORGOTAPP_PROYECT"); // Conexión con la base de datos
    $sql = "SELECT * FROM Usuarios"; // Consulta SQL para seleccionar todos los registros de la tabla Usuarios
    if($u != null)
    $sql.="where usuario='$u'";
    $r= $conexion->query($sql);

    if ($r) {
        // Verifica que la consulta se haya ejecutado correctamente
        if ($r->num_rows > 0) {
            $salida .= "<table>"; // Comienza una tabla para mostrar los resultados
            $salida .= "<tr><th>ID</th><th>Nombre de Usuario</th><th>Correo</th><th>Contraseña</th><th>Cumpleaños</th><th>Teléfono</th><th>N°</th></tr>";

            while ($fila = $r->fetch_assoc()) {
                // Recorre los registros y agrega sus valores a la tabla
                $salida .= "<tr>";
                $salida .= "<td>" . $fila['Id'] . "</td>";
                $salida .= "<td>" . $fila['Nombre_usuario'] . "</td>";
                $salida .= "<td>" . $fila['Correo'] . "</td>";
                $salida .= "<td>" . $fila['Contraseña'] . "</td>";
                $salida .= "<td>" . $fila['Cumpleaños'] . "</td>";
                $salida .= "<td>" . $fila['Telefono'] . "</td>";
                $salida .= "<td>" . $fila['N°'] . "</td>";
                $salida .= "</tr>";
            }

            $salida .= "</table>"; // Cierra la tabla
        } else {
            $salida = "No se encontraron registros en la tabla Usuarios.";
        }
    } else {
        $salida = "Error en la consulta: " . $conexion->error;
    }

    $conexion->close(); // Cierra la conexión

    return $salida; // Retorna el resultado
}


