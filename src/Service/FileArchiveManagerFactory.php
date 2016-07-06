<?php

namespace ArchiveRepertory\Service;
use Omeka\Service;

use ArchiveRepertory\File\ArchiveManager as FileManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileArchiveManagerFactory implements FactoryInterface
{
    static $fileManager;

    public static function setFileManager($fileManager) {
        self::$fileManager=$fileManager;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if (!isset($config['file_manager'])) {
            throw new Exception\ConfigException('Missing file manager configuration');
        }
        $fileManager = $config['file_manager'];
        if (!isset($fileManager['store'])
            || !$serviceLocator->has($fileManager['store'])
        ) {
            throw new \Exception\ConfigException('Missing file store service');
        }
        if (!isset($fileManager['thumbnailer'])
            || !$serviceLocator->has($fileManager['thumbnailer'])
        ) {
            throw new Exception\ConfigException('Missing thumbnailer service');
        }
        if (!isset($fileManager['thumbnail_types'])
            || !is_array($fileManager['thumbnail_types'])
        ) {
            throw new Exception\ConfigException('Missing thumbnail types configuration');
        }
        $thumbnailTypes = $fileManager['thumbnail_types'];
        if (!isset($thumbnailTypes['large'])
            || !isset($thumbnailTypes['medium'])
            || !isset($thumbnailTypes['square'])
        ) {
            throw new Exception\ConfigException('Missing the large, medium, or square thumbnail type configuration');
        }
        foreach ($thumbnailTypes as $thumbnailType) {
            if (!isset($thumbnailType['constraint'])) {
                throw new Exception\ConfigException('Missing constraint for a thumbnail type configuration');
            }
        }
        if (!isset($fileManager['thumbnail_fallbacks'])
            || !is_array($fileManager['thumbnail_fallbacks'])
        ) {
            throw new Exception\ConfigException('Missing thumbnail fallbacks configuration');
        }
        $thumbnailFallbacks = $fileManager['thumbnail_fallbacks'];
        if (!isset($thumbnailFallbacks['default'])
            || !is_array($thumbnailFallbacks['default'])
            || 2 !== count($thumbnailFallbacks['default'])
        ) {
            throw new Exception\ConfigException('Missing default thumbnail fallback configuration');
        }
        if (!isset($thumbnailFallbacks['fallbacks'])
            || !is_array($thumbnailFallbacks['fallbacks'])
        ) {
            throw new Exception\ConfigException('Missing thumbnail fallback configuration');
        }
        foreach ($thumbnailFallbacks['fallbacks'] as $fallback) {
            if (!is_array($fallback) || 2 !== count($fallback)) {
                throw new Exception\ConfigException('Missing thumbnail fallback configuration.');
            }
        }

        if (!isset($config['temp_dir'])) {
            throw new Exception\ConfigException('Missing temporary directory configuration');
        }
        $tempDir = $config['temp_dir'];

        if (self::$fileManager)
            return new self::$fileManager($config['file_manager'], $tempDir, $serviceLocator);

        return new FileManager($config['file_manager'], $tempDir, $serviceLocator);
    }
}
