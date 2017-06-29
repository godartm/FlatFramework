<?php

namespace PrivateHeberg\Flat\ErrorReporting;

use PrivateHeberg\Flat\BasicWrapper;
use PrivateHeberg\Flat\Controller;

class ErrorController extends Controller
{
    public function __construct($error)
    {
        ob_clean();
        ob_start();
        debug_print_backtrace();
        $trace = ob_get_clean();
        $meassage = "erreur test";
        $line = "tagine.php:21";
        $traceE = null;
        $line = explode("\n", $trace);
        foreach ($line as $l) {
            if (!empty($l)) {
                $pat = explode(" at ", $l);
                preg_match_all('/#(.*) /', $l, $matches, PREG_SET_ORDER, 0);
                $id = explode(' ', $matches[0][1]);
                $traceE[] = ['id' => trim($id[0]), 'code' => str_replace("called", "", str_replace('#' . $id[0], '', $pat[0])), 'line' => $pat[1], 'message' => $meassage, 'file_line' => $line];
            }
        }
        echo BasicWrapper::nativeRender(__DIR__ . '/view/', 'error', ['trace' => $traceE]);
    }


}