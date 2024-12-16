<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use ReflectionClass;
use ReflectionProperty;
use Spatie\StructureDiscoverer\Discover;

class MissingDoc
{
    private array $parentCache = [];

    private array $missingDoc = [];

    private int $missingDocPropertyCounter = 0;

    private int $missingDocMethodCounter = 0;

    /**
     * @throws \ReflectionException
     */
    public function dispatch(): Renderable
    {
        $discoverClass = Discover::in(app_path())->classes()->get();

        foreach ($discoverClass as $discover) {
            $reflectionClass = new ReflectionClass($discover);

            foreach (config('custom.missingDoc.classContains') as $classContain) {
                if (str_contains($reflectionClass->name, $classContain)) {
                    continue 2;
                }
            }

            $classDoc = $reflectionClass->getDocComment();
            if ($classDoc) {
                if (str_contains($classDoc, '@missingDoc ignore')) {
                    continue;
                }
            }

            $this->parentCache = [
                'method' => [],
                'property' => [],
            ];
            $this->findParentPropertyMethods($reflectionClass, true);

            $properties = $reflectionClass->getProperties();
            if ($properties) {
                $this->missingDocProperties($properties, $reflectionClass->name);
            }

            $this->missingDocMethods($reflectionClass);
        }

        $missingDoc = $this->missingDoc;
        $missingDocCounter = count($missingDoc);
        $missingDocClassCounter = count($this->missingDoc);
        $missingDocPropertyCounter = $this->missingDocPropertyCounter;
        $missingDocMethodCounter = $this->missingDocMethodCounter;

        d($this->missingDoc);

        return view('code-optimize::missingDoc', compact([
            'missingDoc',
            'missingDocCounter',
            'missingDocClassCounter',
            'missingDocPropertyCounter',
            'missingDocMethodCounter',
        ]));
    }

    private function missingDocProperties(array $properties, string $reflectionClassName): void
    {
        /** @var ReflectionProperty $property */
        foreach ($properties as $property) {
            foreach (config('custom.missingDoc.classContains') as $classContain) {
                if (str_contains($reflectionClassName, $classContain)) {
                    return;
                }
            }

            if ($property->class !== $reflectionClassName) {
                return;
            }

            if (in_array($property->name, $this->parentCache['property'])) {
                return;
            }

            $propertyComment = $property->getDocComment();
            if (! $propertyComment) {
                $this->missingDocPropertyCounter++;
                $prefix = [];

                if ($property->isPrivate()) {
                    $prefix = 'private';
                }
                if ($property->isProtected()) {
                    $prefix = 'protected';
                }
                if ($property->isPublic()) {
                    $prefix = 'public';
                }

                if ($property->isStatic()) {
                    $prefix .= ' static';
                }

                $propertyName = $prefix.' '.$property->getType().' $'.$property->getName();

                $this->missingDoc[$reflectionClassName]['property'][$propertyName] = [
                    'name' => $reflectionClassName,
                    'method' => $propertyName,
                    'lineStart' => '',
                    'lineEnd' => '',
                ];
            }
        }
    }

    private function missingDocMethods(ReflectionClass $reflectionClass): void
    {
        $reflectionClassMethods = $reflectionClass->getMethods();

        foreach ($reflectionClassMethods as $reflectionClassMethod) {
            foreach (config('custom.missingDoc.classContains') as $classContain) {
                if (str_contains($reflectionClassMethod->class, $classContain)) {
                    return;
                }
            }

            foreach (config('custom.missingDoc.methodContains') as $methodContain) {
                if (str_contains($reflectionClassMethod->name, $methodContain)) {
                    return;
                }
            }

            if ($reflectionClassMethod->class !== $reflectionClass->getName()) {
                return;
            }

            if (in_array($reflectionClassMethod->name, $this->parentCache['method'])) {
                return;
            }

            $reflectionClassMethodComment = $reflectionClassMethod->getDocComment();
            if (! $reflectionClassMethodComment) {
                $this->missingDocMethodCounter++;

                if (str_contains($reflectionClassMethod->name, 'testBox')
                    || str_contains($reflectionClassMethod->name, 'rules')
                ) {
                    continue;
                }

                $prefix = '';
                $methodParameter = '()';
                $parameters = $reflectionClassMethod->getParameters();
                if ($parameters) {
                    $methodParameterCollect = [];

                    foreach ($parameters as $parameter) {
                        $methodParameterCollect[] = $parameter->getType().' $'.$parameter->getName();
                    }

                    if ($reflectionClassMethod->isPrivate()) {
                        $prefix = 'private';
                    }
                    if ($reflectionClassMethod->isProtected()) {
                        $prefix = 'protected';
                    }
                    if ($reflectionClassMethod->isPublic()) {
                        $prefix = 'public';
                    }

                    if ($reflectionClassMethod->isStatic()) {
                        $prefix .= ' static';
                    }

                    $methodParameter = ' ('.implode(', ', $methodParameterCollect).')';
                }

                $method = $prefix.' function '.$reflectionClassMethod->name.$methodParameter;

                $this->missingDoc[$reflectionClassMethod->class]['method'][$method] = [
                    'name' => $reflectionClassMethod->class,
                    'method' => $method,
                    'lineStart' => $reflectionClassMethod->getStartLine(),
                    'lineEnd' => $reflectionClassMethod->getEndLine(),
                ];
            }
        }
    }

    public function findParentPropertyMethods(ReflectionClass $reflectionClass, bool $firstCall = false): void
    {
        if (! $firstCall) {
            $methods = $reflectionClass->getMethods();
            if ($methods) {
                foreach ($methods as $method) {
                    $this->parentCache['method'][] = $method->getName();
                }
            }

            $properties = $reflectionClass->getProperties();
            if ($properties) {
                foreach ($properties as $property) {
                    $this->parentCache['property'][] = $property->getName();
                }
            }
        }

        $interfaces = $reflectionClass->getInterfaces();
        $parentClass = $reflectionClass->getParentClass();

        if ($interfaces) {
            foreach ($interfaces as $interface) {
                $this->findParentPropertyMethods($interface);
            }
        }

        if ($parentClass) {
            $this->findParentPropertyMethods($parentClass);
        }
    }
}
