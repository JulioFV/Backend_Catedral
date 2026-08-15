<?php
namespace src\controller;

use src\config\Database;
use src\repository\RepoGeneral;
use src\service\ServiceGeneral;
use src\utils\ResponseHelper;

class ControllerGeneral
{
    private ServiceGeneral $serviceGeneral;

    public function __construct()
    {
        $database = new Database();
        $repo = new RepoGeneral($database);
        $this->serviceGeneral = new ServiceGeneral($repo);
    }
    public function obtenerEstados(): void{
        $result = $this->serviceGeneral->getEstadosGenerales();
        ResponseHelper::json($result,200);
    }
}