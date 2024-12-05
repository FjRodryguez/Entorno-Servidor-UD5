<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductosModel extends BaseDbModel
{
    public const ORDER_COLUMNS = ['codigo', 'nombre', 'nombre_categoria', 'nombre_proveedor', 'stock', 'coste', 'margen', 'pvp'];

    private const FORM = " FROM producto p JOIN categoria c USING(id_categoria) JOIN proveedor pr ON p.proveedor = pr.cif";
    private const SELECT_FORM = "SELECT p.*, c.nombre_categoria, pr.nombre AS nombre_proveedor" . self::FORM;

    private const COUNT = "SELECT COUNT(*)" . self::FORM;

    public function getAll(): array
    {
        $stmt = $this->pdo->query(self::SELECT_FORM);
        return $stmt->fetchAll();
    }

    public function filtrarProductos($filtros, $order, int $page = 1, int $pageSize = -1)
    {
        $condiciones = $this->getCondiciones($filtros);
        if($pageSize < 0){
            $pageSize = (int)$_ENV['usuarios.rows_per_page'];
        }
        $offset = self::getOffset($page, $pageSize);

        $tipoOrder = ($order < 0) ? 'DESC' : 'ASC';
        $order = abs($order);
        if (empty($filtros)) {
            $sql = self::SELECT_FORM . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . " $tipoOrder LIMIT $offset, $pageSize";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } else {
            $sql = self::SELECT_FORM . " WHERE " . implode(" AND ", $condiciones) . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . " $tipoOrder LIMIT $minFilas, $maxFilas";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros);
            return $stmt->fetchAll();
        }
    }

    public function countProductos($filtros): int
    {
        if (empty($filtros)) {
            $stmt = $this->pdo->query(self::COUNT);
            return (int)$stmt->fetchColumn(0);
        } else {
            $condiciones = $this->getCondiciones($filtros);
            $stmt = $this->pdo->prepare(self::COUNT . " WHERE " . implode(" AND ", $condiciones));
            $stmt->execute($filtros);
            return (int)$stmt->fetchColumn(0);
        }
    }

    public static function getOffset(?int $page = 0, int $pageSize = -1): int
    {
        if ($page <= 0) {
            $page = 1;
        }
        if ($pageSize <= 0) {
            $pageSize = $_ENV['usuarios.rows_per_page'];
        }
        return ($page - 1) * $pageSize;
    }

    private function getCondiciones($filtros): array
    {
        $condiciones = [];

        if (isset($filtros['codigo'])) {
            $condiciones[] = "p.codigo LIKE :codigo";
        }
        if (isset($filtros['nombre'])) {
            $condiciones[] = "p.nombre LIKE :nombre";
        }
        if (isset($filtros['categoria'])) {
            $i = 1;
            $categorias = [];
            foreach ($filtros['categoria'] as $categoria) {
                $categorias[':categoria' . $i++] = $categoria;
            }
            unset($filtros['categoria']);
            $filtros = array_merge($filtros, $categorias);
            $condiciones[] = "c.id_categoria IN (" . implode(',', array_keys($categorias)) . ")";
        }
        if (isset($filtros['proveedor'])) {
            $condiciones[] = "pr.cif = :proveedor";
        }
        if (isset($filtros['stock_min'])) {
            $condiciones[] = "p.stock >= :stock_min";
        }
        if (isset($filtros['stock_max'])) {
            $condiciones[] = "p.stock <= :stock_max";
        }
        if (isset($filtros['pvp_min'])) {
            $condiciones[] = "pvp >= :pvp_min";
        }
        if (isset($filtros['pvp_max'])) {
            $condiciones[] = "pvp <= :pvp_max";
        }
        return $condiciones;
    }
}