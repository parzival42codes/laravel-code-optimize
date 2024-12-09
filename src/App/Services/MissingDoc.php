<?php

namespace parzival42codes\LaravelCodeOptimize\App\Services;

use Illuminate\Contracts\Support\Renderable;
use ReflectionClass;
use ReflectionProperty;
use Spatie\StructureDiscoverer\Discover;

class MissingDoc
{
    private array $missingDoc = [];

    private int $missingDocClassCounter = 0;

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

            $classDoc = $reflectionClass->getDocComment();
            if ($classDoc) {
                if (str_contains($classDoc, '@missingDoc ignore')) {
                    continue;
                }
            }

            $this->missingDocClassCounter++;

            $properties = $reflectionClass->getProperties();
            if ($properties) {
                $this->missingDocProperties($properties, $reflectionClass->name);
            }

            $this->missingDocMethods($reflectionClass);
        }

        $missingDoc = $this->missingDoc;
        $missingDocCounter = count($missingDoc);
        $missingDocClassCounter = $this->missingDocClassCounter;
        $missingDocPropertyCounter = $this->missingDocPropertyCounter;
        $missingDocMethodCounter = $this->missingDocMethodCounter;

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

                $this->missingDoc[] = [
                    'name' => $reflectionClassName,
                    'method' => $prefix.' '.$property->getType().' $'.$property->getName(),
                    'lineStart' => '',
                    'lineEnd' => '',
                ];
            }
        }
    }

    private function missingDocMethods($reflectionClass): void
    {
        $reflectionClassMethods = $reflectionClass->getMethods();

        foreach ($reflectionClassMethods as $reflectionClassMethod) {
            $reflectionClassMethodComment = $reflectionClassMethod->getDocComment();
            if (! $reflectionClassMethodComment) {
                $this->missingDocMethodCounter++;

                if (str_contains(
                    $reflectionClassMethod->class,
                    'Symfony\\'
                )
                    || str_contains($reflectionClassMethod->class, 'App\\Console\\')
                    || str_contains($reflectionClassMethod->name, 'testBox')
                    || (str_contains(
                        $reflectionClassMethod->class,
                        'Request'
                    ) && str_contains($reflectionClassMethod->name, 'rules'))
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

                $this->missingDoc[] = [
                    'name' => $reflectionClassMethod->class,
                    'method' => $prefix.' function '.$reflectionClassMethod->name.$methodParameter,
                    'lineStart' => $reflectionClassMethod->getStartLine(),
                    'lineEnd' => $reflectionClassMethod->getEndLine(),
                ];
            }
        }
    }
}
