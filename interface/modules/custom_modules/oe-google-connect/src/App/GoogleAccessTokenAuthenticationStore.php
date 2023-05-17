<?php

/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

namespace Juggernaut\Module\App;

require_once dirname(__FILE__, 3) . "/vendor/autoload.php";

use OpenEMR\Common\Database\QueryUtils;
final class GoogleAccessTokenAuthenticationStore
{
    private array $bindings;
    public function storeAccessTokenAndRefresh($bindings): int
    {
        $this->bindings = $bindings;
        return $this->insertAccessTokenAndRefresh();
    }

    private function insertAccessTokenAndRefresh(): int
    {
        $statement = new QueryUtils();
        $sql = "INSERT INTO `module_google_connect` (`id`, `access_to`, `pid`, `access_token`, `refresh_token`, `expires_in`, `scope`, `token_type`, `date`, `updated`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, NULL); ";
        return $statement::sqlInsert($sql, $this->bindings);
    }
}
