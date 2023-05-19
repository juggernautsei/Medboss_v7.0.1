<?php

/**
 * Config Module.
 *
 * @package   OpenEMR Module
 * @link      http://www.open-emr.org
 * @author    Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2020-2023 Jerry Padgett <sjpadgett@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

$sessionAllowWrite = true;
require_once(__DIR__ . "/../../../globals.php");
$module_config = 1;
?>

<div id="set-services">
    <h3 class="text-center"><?php echo xlt("About Jitsi & 8x8 Services"); ?></h3>
    <div class="row">
        <div class="col-md-12">
            <p><?php echo xlt("Powered by Jitsi, the video meetings platform health professionals can trust. "); ?></p>
            <p><?php echo xlt("Jitsi is a set of open-source projects that allows you to easily build and
            deploy secure video conferencing solutions. At the heart of Jitsi are Jitsi Videobridge and Jitsi
            Meet, which let you have conferences on the internet, while other projects in the community enable
            other features such as audio, dial-in, recording, and simulcasting. "); ?></p>
        </div>
    </div>
</div>
