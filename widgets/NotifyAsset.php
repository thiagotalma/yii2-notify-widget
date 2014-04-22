<?php

/**
 * @copyright Copyright &copy; Thiago Talma, thiagomt.com, 2014
 * @package yii2-notify
 * @version 1.0.0
 */

namespace talma\widgets;

use yii\web\AssetBundle;

/**
 * Asset bundle for Bootstrap Notify Widget
 *
 * @author Thiago Talma <thiago@thiagomt.com>
 * @since 1.0
 */
class NotifyAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * Set up CSS and JS asset arrays based on the base-file names
     * @param string $type whether 'css' or 'js'
     * @param array $files the list of 'css' or 'js' basefile names
     */
    protected function setupAssets($type, $files = [])
    {
        $srcFiles = [];
        $minFiles = [];
        foreach ($files as $file) {
            $srcFiles[] = "{$file}.{$type}";
            $minFiles[] = "{$file}.min.{$type}";
        }
        if (empty($this->$type)) {
            //$this->$type = YII_DEBUG ? $srcFiles : $minFiles;
            $this->$type = $srcFiles;
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/../assets');
        $this->setupAssets('css', ['css/bootstrap-notify']);
        $this->setupAssets('js', ['js/bootstrap-notify']);
        parent::init();
    }

    /**
     * Sets the source path if empty
     * @param string $path the path to be set
     */
    protected function setSourcePath($path)
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        }
    }
}
