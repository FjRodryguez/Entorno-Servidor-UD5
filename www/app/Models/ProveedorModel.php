<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel extends BaseDbModel
{

    public function getAll() : array
    {
        $stmt = $this->pdo->query("SELECT * FROM proveedor ORDER BY nombre");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByCif(string $cif) : ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM proveedor WHERE cif = :cif");
        $stmt->bindParam(':cif', $cif, \PDO::PARAM_STR);
        $stmt->execute();
        if($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
            return $row;
        }else{
            return null;
        }
    }
}