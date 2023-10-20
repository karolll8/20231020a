<?php //se abre php

/**
 * @$salida=texto
 * @param   $u   texto   varchar not null
 * @param   $c   texto   varchar not null
 * @param   $e   texto   varchar null
 * @param   $l   numero  varchar null
 * @return  texto
 *  @mysqli_stmt_bind_param: usados para asociar los valores que se quieren
 *  insertar o consultar en la base de datos con los marcadores de posición
 *  en la consulta SQL.
 */
function consultar($u = null, $c = null, $e = false,$l=null)
{
     $salida = ""; // Inicializa la variable
    $conexion = mysqli_connect("localhost", "root", "root", "RUBLE_FORGOTAPP_PROYECT"); // Conexión con la base de datos
    $sql = "SELECT * FROM Usuarios LIMIT $l"; // Consulta SQL
    if ($u !== null && $c !== null) { // Filtrar por ID y Contraseña
        $sql .= " WHERE Id = ? AND Contraseña = ?";
    } elseif ($u !== null) { // Filtrar solo por ID
        $sql .= " WHERE Id = ?";
    }
    $stmt = mysqli_prepare($conexion, $sql); // Preparar consulta SQL parametrizada
    if ($u !== null && $c !== null) { // Si se especifican tanto $u como $c
        mysqli_stmt_bind_param($stmt, "ss", $u, $c);
    } elseif ($u !== null) { // Si solo se especifica $u
        mysqli_stmt_bind_param($stmt, "s", $u);
    }
    if ($e) { // Si se solicita el conteo de usuarios
        $sql = "SELECT COUNT(*) AS total FROM Usuarios"; // Consulta para contar todos los usuarios
        $stmt = mysqli_prepare($conexion, $sql);//preparar la consulta
        mysqli_stmt_execute($stmt);//ejecutar consulta
        $resultadoCount = mysqli_stmt_get_result($stmt);//obtener los datos de consulta
        $filaCount = mysqli_fetch_assoc($resultadoCount);//incorporarlo como fetch_assoc
        $salida = "Total de usuarios: " . $filaCount['total'];
    } else { // Mostrar los resultados
        if (mysqli_stmt_execute($stmt)) { // Verificar si la consulta fue exitosa
            $resultado = mysqli_stmt_get_result($stmt); // Obtener el resultado
            if ($resultado->num_rows > 0) { // Si hay registros
                while ($fila = $resultado->fetch_assoc()) {
                    $salida .= "<td>" . $fila['Id'] . "</td>";
                    $salida .= "<td>" . $fila['Nombre_usuario'] . "</td>";
                    $salida .= "<td>" . $fila['Correo'] . "</td>";
                    $salida .= "<td>" . $fila['Contraseña'] . "</td>";
                    $salida .= "<td>" . $fila['Cumpleaños'] . "</td>";
                    $salida .= "<td>" . $fila['Telefono'] . "</td>";
                    $salida .= "<td>" . $fila['N°'] . "</td><br>";
                }
            } else {
                $salida = "No se encontraron registros con los filtros especificados.";
            }
        } else {
            $salida = "Error en la consulta: " . mysqli_error($conexion);
        }
    }
    mysqli_stmt_close($stmt); // Cerrar consulta
    $conexion->close(); // Cerrar la conexión
    return $salida; // Retornar el resultado
}
