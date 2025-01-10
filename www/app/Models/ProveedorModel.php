<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{
    private const SELECT_FROM = "SELECT * FROM proveedor";

    private const COUNT = "SELECT COUNT(*) FROM proveedor";

    public const ORDER_COLUMNS = ['cif', 'codigo', 'nombre', 'direccion', 'website', 'pais', 'email', 'telefono'];

    public function getAll(): array
    {
        $stmt = $this->pdo->query(self::SELECT_FROM . " ORDER BY nombre");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByCif(string $cif): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM proveedor WHERE cif = :cif");
        $stmt->bindParam(':cif', $cif, \PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $row;
        } else {
            return null;
        }
    }

    public function getByFiltros($filtros, $order, $page, $pageSize = -1): array
    {
        $tipoOrder = ($order < 0) ? "DESC" : "ASC";
        $order = self::ORDER_COLUMNS[abs($order) - 1];
        if ($pageSize < 1) {
            $pageSize = $_ENV['usuarios.rows_per_page'];
        }

        if (empty($filtros)) {
            $stmt = $this->pdo->query(self::SELECT_FROM . " ORDER BY $order $tipoOrder");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $condiciones = $this->getCondiciones($filtros);
            $stmt = $this->pdo->prepare(self::SELECT_FROM . " WHERE " . implode(" AND ", $condiciones) . " ORDER BY $order $tipoOrder");
            $stmt->execute($filtros);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function getCount($filtros): int
    {
        if (empty($filtros)) {
            $stmt = $this->pdo->query(self::COUNT);
            return (int)$stmt->fetchColumn(0);
        } else {
            $condiciones = $this->getCondiciones($filtros);
            $stmt = $this->pdo->prepare(self::COUNT . " WHERE " . implode(" AND ", $condiciones));
            return (int)$stmt->fetchColumn(0);
        }
    }

    private function getCondiciones($filtros): array
    {
        $condiciones = [];
        if (isset($filtros['cif'])) {
            $condiciones['cif'] = " cif LIKE :cif";
        }
        if (isset($filtros['codigo'])) {
            $condiciones['codigo'] = " codigo LIKE :codigo";
        }
        if (isset($filtros['nombre'])) {
            $condiciones['nombre'] = " nombre LIKE :nombre";
        }
        if (isset($filtros['pais'])) {
            $condiciones['pais'] = " pais LIKE :pais";
        }
        if (isset($filtros['email'])) {
            $condiciones['email'] = " email LIKE :email";
        }
        if (isset($filtros['telefono'])) {
            $condiciones['telefono'] = " telefono LIKE :telefono";
        }
        return $condiciones;
    }

    public static function getOffSet(?int $page = 0, int $pageSize = -1)
    {
        if ($page < 1) {
            $page = 1;
        }
        if ($pageSize <= 0) {
            $pageSize = $_ENV['usuarios.rows_per_page'];
        }

        return ($page - 1) * $pageSize;
    }
}