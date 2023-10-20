<?php //se abre php

/**
 * @$salida=texto
 * @param   $u   texto   varchar not null
 * @param   $c   texto   varchar not null
 * @param   $e   texto   varchar null
 * @param   $l   numero  varchar null
 * @param   $f  texto   varchar null
 * @return  texto
 *  @mysqli_stmt_bind_param: usados para asociar los valores que se quieren
 *  insertar o consultar en la base de datos con los marcadores de posición
 *  en la consulta SQL.
 */
function consultar($u = null, $c = null, $e = false, $f = null, $l = null)
{
    $salida = ""; // Inicializa la variable
    $conexion = new mysqli("localhost", "root", "root", "RUBLE_FORGOTAPP_PROYECT"); // Conexión con la base de datos

    // Consulta SQL
    $sql = "SELECT * FROM Usuarios";
    if ($f !== null) {
        // Si se especifica un campo específico, cambiamos la consulta para seleccionar solo ese campo
        $sql = "SELECT $f FROM Usuarios";
    }

    if ($u !== null && $c !== null) { // Filtrar por ID y Contraseña
        $sql .= " WHERE Id = ? AND Contraseña = ?";
    } elseif ($u !== null) { // Filtrar solo por ID
        $sql .= " WHERE Id = ?";
    }

    if ($l !== null) {
        $sql .= " LIMIT " . intval($l);
    }

    $stmt = $conexion->prepare($sql); // Preparar consulta SQL parametrizada

    if ($u !== null && $c !== null) { // Si se especifican tanto $u como $c
        $stmt->bind_param("ss", $u, $c);
    } elseif ($u !== null) { // Si solo se especifica $u
        $stmt->bind_param("s", $u);
    }

    if ($e) { // Si se solicita el conteo de usuarios
        $sqlCount = "SELECT COUNT(*) AS total FROM Usuarios"; // Consulta para contar todos los usuarios
        $stmt = $conexion->prepare($sqlCount);
        $stmt->execute();
        $resultadoCount = $stmt->get_result();
        $filaCount = $resultadoCount->fetch_assoc();
        $salida = "Total de usuarios: " . $filaCount['total'];
    } else { // Mostrar los resultados
        if ($stmt->execute()) { // Verificar si la consulta fue exitosa
            $resultado = $stmt->get_result(); // Obtener el resultado
            if ($resultado->num_rows > 0) { // Si hay registros
                while ($fila = $resultado->fetch_assoc()) {
                    // Verificar si se especificó un campo específico
                    if ($f !== null) {
                        $salida .= "<td>" . $fila[$f] . "</td>";
                    } else {
                        // Si no se especifica un campo específico, mostrar todos los campos
                        $salida .= "<tr>";
                        $salida .= "<td>" . $fila['Id'] . "</td>";
                        $salida .= "<td>" . $fila['Nombre_usuario'] . "</td>";
                        $salida .= "<td>" . $fila['Correo'] . "</td>";
                        $salida .= "<td>" . $fila['Contraseña'] . "</td>";
                        $salida .= "<td>" . $fila['Cumpleaños'] . "</td>";
                        $salida .= "<td>" . $fila['Telefono'] . "</td>";
                        $salida .= "<td>" . $fila['N°'] . "</td><br>";
                        $salida .= "</tr>";
                    }
                }
            } else {
                $salida = "No se encontraron registros con los filtros especificados.";
            }
        } else {
            $salida = "Error en la consulta: " . $stmt->error;
        }
    }
    $stmt->close(); // Cerrar consulta
    $conexion->close(); // Cerrar la conexión
    return $salida; // Retornar el resultado
}
