<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use Com\Daw2\Libraries\Permisos;

class RolModel extends BaseDbModel
{

    public function getAll()
    {
        $sql = 'SELECT * FROM `rol` ORDER BY rol';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function find(int $idRol)
    {
        $sql = 'SELECT * FROM `rol` WHERE id_rol = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idRol]);
        $row = $stmt->fetch();
        return  ($row === false) ? null : $row;
    }

    public function getPermisos(int $idRol)
    {
        $sql = 'SELECT * FROM `rel_rol_permisos` WHERE id_rol = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idRol]);
        $bdPermisos = $stmt->fetchAll();
        $permisosFinal = [
            'usuarios-sistema' => new Permisos(''),
            'usuarios' => new Permisos(''),
            'csv' => new Permisos('')
        ];
        foreach ($bdPermisos as $permiso) {
            $controlador = $permiso['controlador'];
            $permisos = new Permisos($permiso['permisos']);
            $permisosFinal[$controlador] = $permisos;
        }
        return $permisosFinal;
    }
}