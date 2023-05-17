<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

require_once dirname(__FILE__, 4) . "/globals.php";


    function  collectionsDataPull($site, $firstOfTheMonth, $today): void
    {
        $sql = collectionsQuery($site);
        $data = sqlStatement($sql, [$firstOfTheMonth, $today]);
        $file = dirname(__FILE__, 5) . "/sites/default/documents/logs_and_misc/" .
            date('Y-m-d') . "collection_" . $site . ".csv";
        $fp = fopen($file, 'w');
        while ($row = sqlFetchArray($data)) {
            fputcsv($fp, $row);
            //
        }
        file_put_contents($file, $fp, FILE_APPEND);
    }

    function collectionsQuery($site): string
    {
        return "SELECT f.id, f.date, f.pid, CONCAT(w.lname, ', ', w.fname) AS provider_id, f.encounter,

    f.last_level_billed, f.last_level_closed, f.last_stmt_date, f.stmt_count,

    f.invoice_refno, p.fname, p.mname, p.lname, p.street, p.city, p.state,

    p.postal_code, p.phone_home, p.ss, p.billing_note, p.pubpid, p.DOB,

    CONCAT(u.lname, ', ', u.fname) AS referrer,

    ( SELECT bill_date FROM $site.billing AS b WHERE b.pid = f.pid AND b.encounter = f.encounter AND b.activity = 1 AND b.code_type != 'COPAY' LIMIT 1) AS bill_date,

    ( SELECT SUM(b.fee) FROM $site.billing AS b WHERE b.pid = f.pid AND b.encounter = f.encounter AND b.activity = 1 AND b.code_type != 'COPAY' ) AS charges,

    ( SELECT SUM(b.fee) FROM $site.billing AS b WHERE b.pid = f.pid AND b.encounter = f.encounter AND b.activity = 1 AND b.code_type = 'COPAY' ) AS copays,

    ( SELECT SUM(s.fee) FROM $site.drug_sales AS s WHERE s.pid = f.pid AND s.encounter = f.encounter ) AS sales,

    ( SELECT SUM(a.pay_amount) FROM $site.ar_activity AS a

    WHERE a.pid = f.pid AND a.encounter = f.encounter AND a.deleted IS NULL) AS payments,

    ( SELECT SUM(a.adj_amount) FROM ar_activity AS a WHERE a.pid = f.pid AND a.encounter = f.encounter AND a.deleted IS NULL) AS adjustments

    FROM $site.form_encounter AS f

    JOIN $site.patient_data AS p ON p.pid = f.pid LEFT OUTER JOIN users AS u ON u.id = p.ref_providerID

    LEFT OUTER JOIN $site.users AS w ON w.id = f.provider_id WHERE f.date >= ? AND f.date <= ?  ORDER BY f.pid, f.encounter;";

    }

    function lastDayOfTheMonth($day)
    {
        $month = monthIs();
        switch($month) {
            case 05:
            case 7:
            case 9:
            case 11:
            case 3:
            case 1:
                if ($day == 31) {
                    return true;
                }
                break;
            case 2:
                if ($day == 28) {
                    return true;
                }
                break;
            case 12:
            case 6:
            case 8:
            case 10:
            case 4:
                if ($day == 30) {
                    return true;
                }
                break;
            default:
                return false;
        }
    }

    function getSite()
    {
        $siteDir = $GLOBALS['OE_SITE_DIR'];
        $siteDir = explode("/", ltrim($siteDir));
        $countSlashes = count($siteDir);
        $c = $countSlashes - 1;
        return $siteDir[$c];
    }

    function dayIs()
    {
        return date('j');
    }

    function monthIs()
    {
        return date('m');
    }

    function checkIfLastDayOfTheMonth(): void
    {
        $day = dayIs();
        $today = date('Y-m-d');
        $firstOfTheMonth = date('Y-m-') . '01';
        $islastday = lastDayOfTheMonth($day);
        $site = getSite();
        //if ($islastday) {
            collectionsDataPull($site, $firstOfTheMonth, $today);
        //} else {
          //  echo "is not the last day of the month yet!" . $day;
        //}
    }

    checkIfLastDayOfTheMonth();



