<?php

    /**
     * Bootstrap custom module skeleton.  This file is an example custom module that can be used
     * to create modules that can be utilized inside the OpenEMR system.  It is NOT intended for
     * production and is intended to serve as the barebone requirements you need to get started
     * writing modules that can be installed and used in OpenEMR.
     *
     * @package   OpenEMR
     * @link      http://www.open-emr.org
     *
     * @author    Stephen Nielson <stephen@nielson.org>
     * @copyright Copyright (c) 2021 Stephen Nielson <stephen@nielson.org>
     * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
     */

    namespace Juggernaut\Module\App;

    use OpenEMR\Common\Crypto\CryptoGen;
    use OpenEMR\Services\Globals\GlobalSetting;

    class GlobalConfig
    {
        const CONFIG_OPTION_TEXT = 'oe_project_option_text';
        const CONFIG_OPTION_CLIENT_ENCRYPTED = 'oe_client_id_encrypted';
        const CONFIG_CLIENT_SECRET_ENCRYPTED = 'oe_client_secret_encrypted';
        const CONFIG_OVERRIDE_TEMPLATES = "oe_skeleton_override_twig_templates";
        const CONFIG_ENABLE_MENU = "oe_skeleton_add_menu_button";
        const CONFIG_ENABLE_BODY_FOOTER = "oe_skeleton_add_body_footer";
        const CONFIG_ENABLE_FHIR_API = "oe_skeleton_enable_fhir_api";
        const CONFIG_OPTION_ENCRYPTED = 'oe_skeleton_config_option_encrypted';

        private $globalsArray;

        /**
         * @var CryptoGen
         */
        private $cryptoGen;

        public function __construct(array $globalsArray)
        {
            $this->globalsArray = $globalsArray;
            $this->cryptoGen = new CryptoGen();
        }

        /**
         * Returns true if all of the settings have been configured.  Otherwise it returns false.
         * @return bool
         */
        public function isConfigured()
        {
            $keys = [self::CONFIG_OPTION_TEXT, self::CONFIG_OPTION_ENCRYPTED];
            foreach ($keys as $key) {
                $value = $this->getGlobalSetting($key);
                if (empty($value)) {
                    return false;
                }
            }
            return true;
        }

        public function getTextOption()
        {
            return $this->getGlobalSetting(self::CONFIG_OPTION_TEXT);
        }

        /**
         * Returns our decrypted value if we have one, or false if the value could not be decrypted or is empty.
         * @return bool|string
         */
        public function getEncryptedOption()
        {
            $encryptedValue = $this->getGlobalSetting(self::CONFIG_OPTION_ENCRYPTED);
            return $this->cryptoGen->decryptStandard($encryptedValue);
        }

        public function getGlobalSetting($settingKey)
        {
            return $this->globalsArray[$settingKey] ?? null;
        }

        public function getGlobalSettingSectionConfiguration(): array
        {
            return [/*
                self::CONFIG_OPTION_TEXT => [
                    'title' => 'Google Project Name'
                    ,'description' => 'Enter the name for this project'
                    ,'type' => GlobalSetting::DATA_TYPE_TEXT
                    ,'default' => ''
                ]
                ,self::CONFIG_OPTION_CLIENT_ENCRYPTED => [
                    'title' => 'Google Client ID (Encrypted)'
                    ,'description' => 'Google OAuth 2.0 client ID'
                    ,'type' => GlobalSetting::DATA_TYPE_ENCRYPTED
                    ,'default' => ''
                ]
                ,self::CONFIG_CLIENT_SECRET_ENCRYPTED => [
                    'title' => 'Google Client Secret (Encrypted)'
                    ,'description' => 'Google OAuth 2.0 client ID'
                    ,'type' => GlobalSetting::DATA_TYPE_ENCRYPTED
                    ,'default' => ''
                ]*/
                /*,self::CONFIG_ENABLE_MENU => [
                    'title' => 'Skeleton Module add module menu item'
                    ,'description' => 'Shows example of adding a menu item to the system (requires logging out and logging in again)'
                    ,'type' => GlobalSetting::DATA_TYPE_BOOL
                    ,'default' => ''
                ]
                ,self::CONFIG_ENABLE_BODY_FOOTER => [
                    'title' => 'Skeleton Module Enable Body Footer example.'
                    ,'description' => 'Shows example of adding a menu item to the system (requires logging out and logging in again)'
                    ,'type' => GlobalSetting::DATA_TYPE_BOOL
                    ,'default' => ''
                ]
                ,self::CONFIG_ENABLE_FHIR_API => [
                    'title' => 'Skeleton Module Enable FHIR API Extension example.'
                    ,'description' => 'Shows example of extending the FHIR api with the skeleton module.'
                    ,'type' => GlobalSetting::DATA_TYPE_BOOL
                    ,'default' => ''
                ]*/
            ];
        }
    }
