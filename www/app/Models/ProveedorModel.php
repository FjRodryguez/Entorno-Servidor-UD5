<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM proveedor ORDER BY nombre");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}