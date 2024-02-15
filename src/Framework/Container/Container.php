<?php

namespace Code\Framework\Container;

use Code\Framework\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionUnionType;

class Container implements ContainerInterface
{
    private $servicos = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $callable = $this->servicos[$id];

            return $callable();
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->servicos[$id]);
    }

    public function set(string $id, callable $callable)
    {
        $this->servicos[$id] = $callable;
    }

    private function resolve($id)
    {
        $classeReflection = new \ReflectionClass($id);

        if (!$classeReflection->isInstantiable()) {
            throw new ContainerException("Erro ao instanciar classe {$id}");
        }

        $construtor = $classeReflection->getConstructor();

        if (!$construtor) {
            return new $id;
        }

        $parametros = $construtor->getParameters();

        if (!$parametros) {
            return new $id;
        }

        $dependencias = array_map(function (\ReflectionParameter $param) use ($id) {

            $nomeParam = $param->getName();
            $tipoParam = $param->getType();

            if (!$tipoParam) {
                throw new ContainerException("Não conseguimos resolver o parametro {$nomeParam} pois o
                 tipo é inválido no serviço: {$id}");
            }

            if ($tipoParam instanceof \ReflectionUnionType) {
                throw new ContainerException("Não conseguimos resolver o parametro {$nomeParam} pois não
                trabalhamos com Unio Types");
            }

            if ($tipoParam instanceof \ReflectionNamedType && !$tipoParam->isBuiltin()) {
                return $this->get($tipoParam->getName());
            }

            throw new ContainerException("Não conseguimos resolver o serviço: {$id}");
        }, $parametros);

        return $classeReflection->newInstanceArgs($dependencias);
    }
}
