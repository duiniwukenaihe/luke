<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\IdentityProvider\App;

use Doctrine\DBAL\Connection;
use Silex\Application as SilexApplication;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\HttpFoundation\Session\Session;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Sugarcrm\IdentityProvider\App\Provider\AuthProviderManagerProvider;
use Sugarcrm\IdentityProvider\App\Provider\ConfigServiceProvider;
use Sugarcrm\IdentityProvider\App\Provider\UserMappingServiceProvider;
use Sugarcrm\IdentityProvider\App\Authentication\UserMappingService;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\PsrLogMessageProcessor;

class Application extends SilexApplication
{
    const ENV_PROD = 'prod';
    const ENV_DEV = 'dev';
    const ENV_TESTS = 'tests';
    const ENV_DEFAULT = self::ENV_PROD;

    /**
     * @var string
     */
    protected $env;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * Allowed environments
     * @var array
     */
    protected $allowedEnv = [
        self::ENV_TESTS,
        self::ENV_DEV,
        self::ENV_PROD,
    ];

    /**
     * @inheritdoc
     */
    public function __construct(array $values = ['env' => self::ENV_DEFAULT])
    {
        $environment = (string) $values['env'];
        $this->env = in_array($environment, $this->allowedEnv) ? $environment : self::ENV_DEFAULT;

        $this->rootDir = realpath(__DIR__ . '/../../');

        parent::__construct();

        $this->register(new ConfigServiceProvider(isset($values['configOverride']) ? $values['configOverride'] : []));

        $this->register(new MonologServiceProvider(), $this['config']['monolog']);
        $this->extend('monolog', function (Logger $monolog, Application $app) {
            return $monolog->pushProcessor(new UidProcessor())
                ->pushProcessor(new WebProcessor())
                ->pushProcessor(new IntrospectionProcessor())
                ->pushProcessor(new PsrLogMessageProcessor());
        });

        $this->register(new TwigServiceProvider(), [
            'twig.options' => [
                'cache' => $this->rootDir . '/var/cache/twig',
                'strict_variables' => true,
            ],
            'twig.path' => __DIR__ . '/Resources/views',
        ]);

        $this->register(new ValidatorServiceProvider());

        $this->register(new DoctrineServiceProvider(), $this['config']['db']);

        $this->register(new SessionServiceProvider(), [
            'session.test' => $environment === self::ENV_TESTS,
        ]);

        $this->register(new AuthProviderManagerProvider());

        $this->register(new UserMappingServiceProvider());

        // bind routes
        $this->mount('', new ControllerProvider());
    }

    /**
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * SERVICE ACCESSORS
     */

    /**
     * @return \Twig_Environment
     */
    public function getTwigService()
    {
        return $this['twig'];
    }

    /**
     * @return RecursiveValidator
     */
    public function getValidatorService()
    {
        return $this['validator'];
    }

    /**
     * @return Connection
     */
    public function getDoctrineService()
    {
        return $this['db'];
    }

    /**
     * @return AuthenticationProviderManager
     */
    public function getAuthManagerService()
    {
        return $this['authManager'];
    }

    /**
     * @return UrlGenerator
     */
    public function getUrlGeneratorService()
    {
        return $this['url_generator'];
    }

    /**
     * @return LoggerInterface;
     */
    public function getLogger()
    {
        return $this['logger'];
    }

    /**
     * @return Session;
     */
    public function getSession()
    {
        return $this['session'];
    }

    /**
     * @return UserMappingService
     */
    public function getUserMappingService()
    {
        return $this['userMapping'];
    }
}
