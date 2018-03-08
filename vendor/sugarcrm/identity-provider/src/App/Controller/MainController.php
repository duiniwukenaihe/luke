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

namespace Sugarcrm\IdentityProvider\App\Controller;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class MainController.
 */
class MainController
{
    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function loginEndPointAction(Application $app, Request $request)
    {
        $params = [
            'user_name' => $request->get('user_name'),
            'provider' => $request->get('provider'),
        ];
        $app->getLogger()->info('Successfully authentication status page render', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);
        return $app->getTwigService()->render('main/status.html.twig', $params);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function renderFormAction(Application $app, Request $request)
    {
        return $this->renderLoginForm($app);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function postFormAction(Application $app, Request $request)
    {
        // setup form params
        $activeProviders = array_keys($this->getActiveProviders());

        // collect data
        $data = [
            'user_name' => $request->get('user_name'),
            'password' => $request->get('password'),
            'provider' => $request->get('provider'),
        ];

        // build constraints
        $errorMessage = 'All fields are required.';
        $constraint = new Assert\Collection([
            'user_name' => [new Assert\NotBlank(['message' => $errorMessage])],
            'password' => [new Assert\NotBlank(['message' => $errorMessage])],
            'provider' => [
                new Assert\NotBlank(),
                new Assert\Choice(
                    ['choices' => $activeProviders]
                )
            ],
        ]);

        // validate
        $app->getLogger()->debug('Validation form data', [
            'data' => $data,
            'tags' => ['IdM.main'],
        ]);
        $errors = $app->getValidatorService()->validate($data, $constraint);
        $messages = [];
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                /* @var ConstraintViolation $error */
                if (in_array(trim($error->getPropertyPath(), '[]'), ['user_name', 'password'])) {
                    $messages[] = $error->getMessage();
                } else {
                    $messages[] = $error->getPropertyPath() . ' ' . $error->getMessage();
                }
            }
            $messages = array_unique($messages);

            $app->getLogger()->debug('Invalid form with errors', [
                'errors' => $errors,
                'tags' => ['IdM.main'],
            ]);
            /**
             * Render errors.
             */
            return $this->renderLoginForm($app, [
                'user_name' => $data['user_name'],
                'provider' => $data['provider'],
                'messages' => $messages,
            ]);
        }

        // if no constraints errors

        // todo need to create a provider specific token
        $token = new UsernamePasswordToken(
            $data['user_name'],
            $data['password'],
            $data['provider']
        );

        try {
            $app->getLogger()->info('Authentication token for user:{user_name}', [
                'user_name' => $token->getUsername(),
                'tags' => ['IdM.main'],
            ]);
            $token = $app->getAuthManagerService()->authenticate($token);
        } catch (BadCredentialsException $e) {
            $messages[] = 'Invalid username or password';

            $app->getLogger()->notice('Bad credentials occurred for user:{user_name}', [
                'user_name' => $token->getUsername(),
                'tags' => ['IdM.main'],
            ]);
        } catch (AuthenticationException $e) {
            $messages[] = $e->getMessage();

            $app->getLogger()->warning('Authentication Exception occurred for user:{user_name}', [
                'user_name' => $token->getUsername(),
                'exception' => $e,
                'tags' => ['IdM.main'],
            ]);
        } catch (\Exception $e) {
            $messages[] = 'APP ERROR: ' . $e->getMessage();

            $app->getLogger()->error('Exception occurred for user:{user_name}', [
                'user_name' => $token->getUsername(),
                'exception' => $e,
                'tags' => ['IdM.main'],
            ]);
        }

        if ($token->isAuthenticated()) {
            $app->getLogger()->info('Redirect user:{user_name} to route:{route}', [
                'user_name' => $token->getUsername(),
                'route' => 'loginEndPoint',
                'tags' => ['IdM.main'],
            ]);
            return RedirectResponse::create($app->getUrlGeneratorService()->generate(
                'loginEndPoint', [
                    'user_name' => $token->getUsername(),
                    'provider' => $this->getActiveProviders()[$data['provider']],
                ]
            ));
        }

        return $this->renderLoginForm($app, [
            'user_name' => $data['user_name'],
            'provider' => $data['provider'],
            'messages' => $messages,
        ]);
    }



    /**
     * @param Application $app
     * @param array $params
     * @return string
     */
    protected function renderLoginForm(Application $app, array $params = [])
    {
        $app->getLogger()->info('Render login form', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);
        return $app->getTwigService()->render('main/userPasswordForm.html.twig', array_merge([
            'providers' => $this->getActiveProviders(),
        ], $params));
    }

    /**
     * todo it is not a part of the controller. need to move it out to the external class
     * @return array
     */
    protected function getActiveProviders()
    {
        return [
            AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL => 'Local',
            AuthProviderManagerBuilder::PROVIDER_KEY_LDAP => 'LDAP',
        ];
    }
}
