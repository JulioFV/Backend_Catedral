<?php
namespace src\service;

use src\repository\RepoGeneral;

class ServiceGeneral
{
    private RepoGeneral $repoGeneral;

    public function __construct(RepoGeneral $repoGeneral)
    {
        $this->repoGeneral = $repoGeneral;
    }

    public function getEstadosGenerales(): array{
        $generales = $this->repoGeneral->obtenerEstadosGenerales();
        return [
            'success' => true,
            'data' => $generales
        ];
    }
}