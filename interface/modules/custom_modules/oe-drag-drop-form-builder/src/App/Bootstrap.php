<?php

/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

namespace Juggernaut\Module\App;

use Google\Exception;
use OpenEMR\Core\Kernel;
use OpenEMR\Events\Globals\GlobalsInitializedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use OpenEMR\Services\Globals\GlobalSetting;
use Google\Client;

class Bootstrap
{
    const MODULE_INSTALLATION_PATH = "/interface/modules/custom_modules/";
    const MODULE_NAME = "oe-google-connect";
    private GlobalConfig $globalsConfig;

    public function __construct(EventDispatcherInterface $eventDispatcher, ?Kernel $kernel = null)
    {
        global $GLOBALS;

        if (empty($kernel)) {
            $kernel = new Kernel();
        }

        $this->eventDispatcher = $eventDispatcher;

        // we inject our globals value.
        $this->globalsConfig = new GlobalConfig($GLOBALS);
    }

    /**
     * @throws Exception
     */
    public function getGoogleOAuth(Client $client)
    {
       $client->setAuthConfig('client_secret.json');
       $client->addScope(Google\Service\Drive::DRIVE_METADATA_READONLY);
       $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
       $client->setAccessType('offline');
       $client->setApprovalPrompt('consent');
       $client->setIncludeGrantedScopes(true); // incremental auth

        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    }

    /**
     * @return GlobalConfig
     */
    public function getGlobalConfig(): GlobalConfig
    {
        return $this->globalsConfig;
    }

    public function addGlobalSettings(): void
    {
        $this->eventDispatcher->addListener(GlobalsInitializedEvent::EVENT_HANDLE, [$this, 'addGlobalSettingsSection']);
    }

    /**
     * @throws \Exception
     */
    public function addGlobalSettingsSection(GlobalsInitializedEvent $globalsInitializedEvent): void
    {
        global $GLOBALS;

        $service = $globalsInitializedEvent->getGlobalsService();
        $section = xlt('Google Services');
        $service->createSection($section, 'Insurance');

        $settings = $this->globalsConfig->getGlobalSettingSectionConfiguration();

        foreach ($settings as $key => $config) {
            $value = $GLOBALS[$key] ?? $config['default'];
            $service->appendToSection(
                $section,
                $key,
                new GlobalSetting(
                    xlt($config['title']),
                    $config['type'],
                    $value,
                    xlt($config['description']),
                    true
                )
            );
        }
    }

    public function subscribeToEvents(): void
    {
        $this->addGlobalSettings();
    }
}
