<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuarioSistemaModel extends BaseDbModel
{
    const ORDER = ['nombre'];
    const DEFAULT_USER_IMAGE = 'assets/img/user2-160x160.jpg';
    const SELECT_FROM = "SELECT * FROM usuario_sistema LEFT JOIN rol ON rol.id_rol = usuario_sistema.id_rol";

    public function getAll(): array
    {
        $query = self::SELECT_FROM . " ORDER BY nombre";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function login($email, $password): ?array
    {
        $row = $this->getByEmail($email);
        if ($row !== null) {
            if (password_verify($password, $row['pass'])) {
                return $row;
            }
        }
        return null;
    }

    /**
     * @param array $data
     * @return bool|int Id del usuario generado. False otherwise
     */
    public function insertUsuarioSistema(array $data): bool|int
    {
        $sql = "INSERT INTO usuario_sistema (id_rol, email, pass, nombre, idioma, baja)
                VALUES (:id_rol, :email, :pass, :nombre, :idioma, :baja)";
        $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute($data)) {
            return (int)$this->pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public function editUsuario(int $id, array $data): bool|int
    {
        $sql = "UPDATE usuario_sistema SET id_rol=:id_rol, email=:email, pass=:password, nombre=:nombre, idioma=:idioma, baja=:baja WHERE id_usuario = :id";
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteUsuario(int $id): bool
    {
        $sql = "DELETE FROM usuario_sistema WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() === 1;
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM usuario_sistema WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : null;
    }

    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuario_sistema WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row !== false) {
            $userImgLocation = $this->expectedUserImage((int)$row['id_usuario']);
            if (file_exists($userImgLocation)) {
                $row['image'] = $userImgLocation;
            } else {
                $row['image'] = self::DEFAULT_USER_IMAGE;
            }
        }
        return $row !== false ? $row : null;
    }

    public function expectedUserImage(int $id): string
    {
        return $_ENV['folder.user_images'] . $id . '_profile';
    }

    public function setLastDate(int $id): bool
    {
        $sql = "UPDATE usuario_sistema SET last_date = NOW() WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
