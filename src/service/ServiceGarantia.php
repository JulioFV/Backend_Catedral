<?php
namespace src\service;

use src\repository\RepoGarantia;
use src\model\Garantia;

class ServiceGarantia
{
    private RepoGarantia $repoGarantia;

    public function __construct(RepoGarantia $repoGarantia)
    {
        $this->repoGarantia = $repoGarantia;
    }

    public function createGarantia(array $data): array{
        if (!isset($data['nombre']) || trim($data['nombre']) === '') {
            return [
                'success' => false,
                'message' => 'El nombre de la garantía es obligatorio.'
            ];
        }

        $garantia = new Garantia(
            null,
            $data['nombre']
        );
        $result = $this->repoGarantia->createGarantia($garantia);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Garantía creada correctamente.'
            ];
        }

        return [
            'success' => false,
            'message' => 'No se pudo crear la garantía.'
        ];
    }

    public function getAllGarantias(): array{
        $garantias = $this->repoGarantia->getAllGarantias();

        return [
            'success' => true,
            'data' => $garantias
        ];
    }
}