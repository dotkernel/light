<?php

declare(strict_types=1);

namespace Light\App;

use Core\App\DBAL\Types\SuccessFailureEnumType;
use Core\App\DBAL\Types\YesNoEnumType;
use Core\App\Factory\EntityListenerResolverFactory;
use Core\App\Resolver\EntityListenerResolver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Dot\Cache\Adapter\ArrayAdapter;
use Dot\Cache\Adapter\FilesystemAdapter;
use Light\App\Factory\GetIndexViewHandlerFactory;
use Light\App\Handler\GetIndexViewHandler;
use Mezzio\Application;
use Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType;
use Ramsey\Uuid\Doctrine\UuidBinaryType;
use Ramsey\Uuid\Doctrine\UuidType;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

class ConfigProvider
{
    /**
    @return array{
     *     dependencies: array<mixed>,
     *     templates: array<mixed>,
     * }
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrineConfig(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * @return array{
     *     delegators: array<class-string, array<class-string>>,
     *     factories: array<class-string, class-string>,
     * }
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
                GetIndexViewHandler::class => GetIndexViewHandlerFactory::class,
            ],
            'aliases' => [
                EntityManager::class          => 'doctrine.entity_manager.orm_default',
                EntityManagerInterface::class => 'doctrine.entity_manager.orm_default',
            ]
        ];
    }

    /**
     * @return array{
     *     paths: array{
     *          app: array{literal-string&non-falsy-string},
     *          error: array{literal-string&non-falsy-string},
     *          layout: array{literal-string&non-falsy-string},
     *          partial: array{literal-string&non-falsy-string},
     *     }
     * }
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'     => [__DIR__ . '/../templates/app'],
                'error'   => [__DIR__ . '/../templates/error'],
                'layout'  => [__DIR__ . '/../templates/layout'],
                'partial' => [__DIR__ . '/../templates/partial'],
            ],
        ];
    }

    private function getDoctrineConfig(): array
    {
        return [
            'cache'         => [
                'array'      => [
                    'class' => ArrayAdapter::class,
                ],
                'filesystem' => [
                    'class'     => FilesystemAdapter::class,
                    'directory' => getcwd() . '/data/cache',
                    'namespace' => 'doctrine',
                ],
            ],
            'configuration' => [
                'orm_default' => [
                    'result_cache'             => 'filesystem',
                    'metadata_cache'           => 'filesystem',
                    'query_cache'              => 'filesystem',
                    'hydration_cache'          => 'array',
                    'typed_field_mapper'       => null,
                    'second_level_cache'       => [
                        'enabled'                    => true,
                        'default_lifetime'           => 3600,
                        'default_lock_lifetime'      => 60,
                        'file_lock_region_directory' => '',
                        'regions'                    => [],
                    ],
                ],
            ],
            'connection'    => [
                'orm_default' => [
                    'doctrine_mapping_types' => [
                        UuidBinaryType::NAME            => 'binary',
                        UuidBinaryOrderedTimeType::NAME => 'binary',
                    ],
                ],
            ],
            'driver'        => [
                // The default metadata driver aggregates all other drivers into a single one.
                // Override `orm_default` only if you know what you're doing.
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                ],
            ],
            'migrations'    => [
                'migrations_paths'        => [
                    'Migrations' => 'src/Migrations',
                ],
                'all_or_nothing'          => true,
                'check_database_platform' => true,
            ],
            'types'         => [
                UuidType::NAME                  => UuidType::class,
                UuidBinaryType::NAME            => UuidBinaryType::class,
                UuidBinaryOrderedTimeType::NAME => UuidBinaryOrderedTimeType::class,
            ],
        ];
    }
}
