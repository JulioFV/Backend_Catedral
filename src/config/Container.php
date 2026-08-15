<?php
namespace src\config;

use ReflectionClass;
use Exception;

class Container
{
    public function make($class)
    {
        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new Exception("La clase {$class} no es instanciable");
        }

        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type === null || $type->isBuiltin()) {
                throw new Exception("No se puede resolver la dependencia {$parameter->getName()} en {$class}");
            }

            $dependencies[] = $this->make($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}