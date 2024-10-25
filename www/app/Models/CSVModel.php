<?php

namespace Com\Daw2\Models;

use http\Exception\InvalidArgumentException;

class CSVModel
{
    public const COL_MUNICIPIO = 0;
    public const COL_SEXO = 0;
    public const COL_ANHO = 0;

    public function __construct(private string $filename)
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException("File $filename does not exist");
        }
    }

    public function loadData(): array
    {
        $csvFile = file($this->filename);
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';');
        }
        return $data;
    }

    /**
     * @param array $data
     * @return bool true si se inserta el registro. False otherwise
     * @throws \ErrorException si no se tiene permisos sobre los ficheros
     */
    public function insertPoblacionPontevedra(array $data): bool
    {
        set_error_handler(function () {
            throw new \ErrorException('No se ha podido realizar la operación');
        }, E_WARNING);
        $resource = fopen($this->filename, 'a');
        $resultado = fputcsv($resource, $data, ';');
        fclose($resource);
        restore_error_handler();
        return $resultado !== false;
    }

    /**
     * @param string $municipio
     * @param string $sexo
     * @param int $anho
     * @return bool
     * @throws \ErrorException su bi se tienen permisos sobre los ficheros
     */
    public function existeDate(string $municipio, string $sexo, int $anho): bool
    {
        set_error_handler(function () {
            throw new \ErrorException('No se ha podido realizar la operación');
        }, E_WARNING);
        $datos = $this->loadData();
        restore_error_handler();
        foreach ($datos as $fila) {
            if (($fila[self::COL_MUNICIPIO] == $municipio) && ($fila[self::COL_SEXO] == $sexo) && $fila[self::COL_ANHO] == $anho) {
                return true;
            }
        }
        return false;
    }
}