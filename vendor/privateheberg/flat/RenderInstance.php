<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 22/02/2017
 * Time: 22:05
 */

namespace PrivateHeberg\Flat;


class RenderInstance
{
    private $view_name;
    private $view_path;
    private $view_path_cached;
    private $model;

    /**
     * @return mixed
     */
    public function getViewName()
    {
        return $this->view_name;
    }

    /**
     * @param mixed $view_name
     */
    public function setViewName($view_name)
    {
        $this->view_name = $view_name;
    }

    /**
     * @return mixed
     */
    public function getViewPath()
    {
        return $this->view_path;
    }

    /**
     * @param mixed $view_path
     */
    public function setViewPath($view_path)
    {
        $this->view_path = $view_path;
    }

    /**
     * @return mixed
     */
    public function getViewPathCached()
    {
        return $this->view_path_cached;
    }

    /**
     * @param mixed $view_path_cached
     */
    public function setViewPathCached($view_path_cached)
    {
        $this->view_path_cached = $view_path_cached;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
}