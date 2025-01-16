<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class CategoriaModel extends BaseDbModel
{
    private const ORDER_STRING = ' ORDER BY nombre_categoria ASC';
    function getAllCategorias(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categoria ORDER BY nombre_categoria");
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categorias as &$categoria) {
            $categoria['nombre_completo'] = $this->getPadre($categoria['id_padre']) . $categoria['nombre_categoria'];
        }
        return $categorias;
    }

    public function get(array $filtros = []): array
    {
        $sql = 'SELECT * FROM categoria';
        $condiciones = [];
        $variables = [];
        if (!empty($filtros['nombre_categoria'])) {
            $condiciones[] = 'nombre_categoria LIKE :nombre_categoria';
            $variables['nombre_categoria'] = "%" . $filtros['nombre_categoria'] . "%";
        }
        if ($condiciones === []) {
            $stmt = $this->pdo->query($sql . self::ORDER_STRING);
        } else {
            $sql .= ' WHERE ' . implode(' AND ', $condiciones) . self::ORDER_STRING;
            $stmt = $this->pdo->prepare($sql);
        }
        $stmt->execute($variables);
        return $stmt->fetchAll();
    }

    private function getPadre($idPadre)
    {
        $res = '';
        while (!is_null($idPadre)) {
            $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :idPadre");
            $stmt->execute([':idPadre' => $idPadre]);
            $padre = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPadre = $padre['id_padre'];
            $res .= $padre['nombre_categoria'] . '>';
        }
        return $res;
    }

    public function getCategoria(int $idCategoria): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :idCategoria");
        $stmt->execute([':idCategoria' => $idCategoria]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        } else {
            return null;
        }
    }
}