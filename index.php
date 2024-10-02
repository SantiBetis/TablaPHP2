<?php
require_once './php/connection.php';

$con = connection();

$sql = "SELECT p.ProductName, c.CategoryName, p.UnitPrice
FROM Products p
JOIN Categories c ON p.CategoryID = c.CategoryID
WHERE p.UnitPrice > (
    SELECT AVG(p2.UnitPrice)
    FROM Products p2
    WHERE p2.CategoryID = p.CategoryID
)
ORDER BY c.CategoryName, p.UnitPrice DESC;";
$query = mysqli_query($con, $sql);




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos de Northwind</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: lightgreen;
        }
       
    </style>
</head>
<body>

    <h1>Lista de Productos - Northwind</h1>

    <table>
        <thead>
            <tr>
                <th>ProductName</th>
                <th>CategoryName</th>
                <th>UnitPrice</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?php echo $row["ProductName"]; ?></td>
                        <td><?php echo $row["CategoryName"]; ?></td>
                        <td><?php echo $row["UnitPrice"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No se encontraron productos</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>