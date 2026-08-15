<?php
namespace src\utils;

final class EstatusPrestamo
{
    const ACTIVO   = 1; // Prestado, nada devuelto aún
    const DEVUELTO = 2; // Devolución completa
    const PARCIAL  = 3; // Devolución parcial (aún queda cantidad pendiente)
}