<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Displays status of phpMyAdmin configuration storage
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

use PhpMyAdmin\Relation;
use PhpMyAdmin\Response;

require_once 'libraries/common.inc.php';

$relation = new Relation($GLOBALS['dbi']);

// If request for creating the pmadb
if (isset($_POST['create_pmadb'])) {
    if ($relation->createPmaDatabase()) {
        $relation->fixPmaTables('phpmyadmin');
    }
}

// If request for creating all PMA tables.
if (isset($_POST['fixall_pmadb'])) {
    $relation->fixPmaTables($GLOBALS['db']);
}

$cfgRelation = $relation->getRelationsParam();
// If request for creating missing PMA tables.
if (isset($_POST['fix_pmadb'])) {
    $relation->fixPmaTables($cfgRelation['db']);
}

$response = Response::getInstance();
$response->addHTML(
    $relation->getRelationsParamDiagnostic($cfgRelation)
);
