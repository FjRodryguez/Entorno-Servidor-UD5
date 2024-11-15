<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel extends BaseDbModel
{

    private const SELECT_FROM = "SELECT *, c.nombre_categoria, pr.nombre FROM producto p JOIN categoria c using (categoria_id) JOIN proveedor on p.proveedor = pr.cif";

    public function getAll(): array
    {
        $stmt = $this->pdo->query(self::SELECT_FROM);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}