<?php
namespace src\utils;
class NormalizadorRespuestas {
    function normalizarTexto($texto): string{
        // Convertir a minúsculas
        $texto = mb_strtolower($texto, 'UTF-8');
        
        // Eliminar espacios en blanco (al inicio, final y dobles espacios)
        $texto = trim($texto);
        $texto = preg_replace('/\s+/', '', $texto);

        // Normalizar acentos
        $acentos = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ñ' => 'n'
        );
        $texto = strtr($texto, $acentos);

        return $texto;
    }
}