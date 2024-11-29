<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class CategoriaModel extends BaseDbModel
{
    function getAllCategorias()
    {
        $stmt = $this->pdo->query("SELECT * FROM categoria ORDER BY nombre_categoria");
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categorias as &$categoria) {
            $categoria['nombre_completo'] = $this->getPadre($categoria['id_padre']) . $categoria['nombre_categoria'];
        }
        return $categorias;
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
}