<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 03/11/2016
 * Time: 06:56
 */

namespace PrivateHeberg\Flat;


use Xiaoler\Blade\Compilers\BladeCompiler;
use Xiaoler\Blade\Engines\CompilerEngine;
use Xiaoler\Blade\Factory;
use Xiaoler\Blade\FileViewFinder;

class Templating
{

    public $ri;

    public $router;

    public $pageData;

    public function __construct(RenderInstance $ri)
    {

        $this->ri = $ri;
        $compiller = new BladeCompiler($this->ri->getViewPathCached());
        $engine = new CompilerEngine($compiller);
        $finder = new FileViewFinder(array($this->ri->getViewPath()));
        $factory = new Factory($engine, $finder);


        $compiller->directive('route', function ($route) {
            return '' . $this->fxRoute($route) . '';
        });

        $compiller->directive('asset', function ($route) {
            return '' . $this->fxAsset($route) . '';
        });

        $compiller->directive('url', function ($route) {
            return '' . $this->fxAsset($route) . '';
        });

        $compiller->directive('trans', function ($route) {
            return '' . $this->fxTrans($route) . '';
        });

        $this->pageData = $factory->make($this->ri->getViewName(), $this->ri->getModel())->render();
    }

    private function fxRoute($name)
    {
        return BasicWrapper::route($this->formatData($name));
    }

    private function formatData($string)
    {
        if (strstr($string, '("')) {
            return str_replace('("', '', str_replace('")', '', $string));
        }

        return str_replace('(\'', '', str_replace('\')', '', $string));
    }

    private function fxAsset($name)
    {

        return _CONFIG['uri'] . $this->formatData($name);
    }

    private function fxTrans($string)
    {
        return BasicWrapper::trans($this->formatData($string));
    }

    public function get()
    {
        return $this->pageData;
    }
}