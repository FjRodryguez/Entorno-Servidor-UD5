<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class RolModel extends BaseDbModel
{

    public function getAll()
    {
        $sql = 'SELECT * FROM `rol` ORDER BY rol';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function find(int $id) :?array
    {
        $sql = 'SELECT * FROM `rol` WHERE id_rol = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

}