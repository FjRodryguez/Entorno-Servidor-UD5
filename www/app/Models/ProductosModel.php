<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductosModel extends BaseDbModel
{
    private const SELECT_FORM = "SELECT p.*, c.nombre_categoria, pr.nombre AS nombre_proveedor, (p.coste * p.margen * ((100 + p.iva) / 100)) AS pvp FROM producto p JOIN categoria c USING(id_categoria) JOIN proveedor pr ON p.proveedor = pr.cif";

    public function getAll(): array
    {
        $stmt = $this->pdo->query(self::SELECT_FORM);
        return $stmt->fetchAll();
    }

    public function filtrarProductos($filtros)
    {
        $condiciones = [];

        if(isset($filtros['codigo'])){
            $condiciones[] = "p.codigo LIKE :codigo";
        }
        if(isset($filtros['nombre'])){
            $condiciones[] = "p.nombre LIKE :nombre";
        }
        if(isset($filtros['categoria'])){
            $condiciones[] = "c.id_categoria = :categoria";
        }
        if(isset($filtros['proveedor'])){
            $condiciones[] = "pr.cif = :proveedor";
        }
        if(isset($filtros['stock_min'])){
            $condiciones[] = "p.stock >= :stock_min";
        }
        if(isset($filtros['stock_max'])){
            $condiciones[] = "p.stock <= :stock_max";
        }
        if(isset($filtros['pvp_min'])){
            $condiciones[] = "pvp >= :pvp_min";
        }
        if(isset($filtros['pvp_max'])){
            $condiciones[] = "pvp <= :pvp_max";
        }
        if(empty($filtros)){
            return $this->getAll();
        }else{
            $sql = self::SELECT_FORM . " WHERE " . implode(" AND ", $condiciones);
            echo $sql;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros);
            return $stmt->fetchAll();
        }
    }
}