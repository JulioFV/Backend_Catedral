<?php
namespace src\controller;

use src\config\Database;
use src\repository\RepoGarantia;
use src\service\ServiceGarantia;
use src\utils\ResponseHelper;

class ControllerGarantia
{
    private ServiceGarantia $serviceGarantia;

    public function __construct()
    {
        $database = new Database();
        $repo = new RepoGarantia($database);
        $this->serviceGarantia = new ServiceGarantia($repo);
    }

    public function createGarantia(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            ResponseHelper::json([
                'success' => false,
                'message' => 'JSON inválido.'
            ], 400);
        }

        $result = $this->serviceGarantia->createGarantia($data);

        ResponseHelper::json(
            $result,
            $result['success'] ? 201 : 400
        );
    }

    public function getAllGarantias(): void
    {
        $result = $this->serviceGarantia->getAllGarantias();

        ResponseHelper::json($result, 200);
    }
}