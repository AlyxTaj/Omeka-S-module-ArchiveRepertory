<?php
namespace ArchiveRepertory\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class PropertySelect extends Select
{
    use ServiceLocatorAwareTrait;

    /**
     * Construct the object.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name Optional name for the form (and CSRF name)
     * @param array $options Optional options for the form
     */
    public function __construct(ServiceLocatorInterface $serviceLocator,
        $name = null, $options = []
    ) {
        $this->setServiceLocator($serviceLocator);
        parent::__construct($name, $options);
    }

    /**
     * Set API resources as value options.
     *
     * Sets the resource ID as the option value and the return value of
     * $callback as the option text. The callback receives the resource
     * representation as the first argument and the service locator as the
     * second.
     *
     * @param string $resource The API resource name
     * @param array $query The API request query
     * @param callable $callback A callback that returns option text
     */
    public function setResourceValueOptions($resource, array $query,
        callable $callback
    ) {
        $serviceLocator = $this->getServiceLocator();
        $api = $serviceLocator->get('Omeka\ApiManager');

        $response = $api->search($resource, $query);
        if ($response->isError()) {
            return;
        }
        $vocabularies = $api->search('vocabularies')->getContent();
        $valueOptions = [];


        foreach ($vocabularies as $vocabulary) {
            $options = [];
            foreach ($vocabulary->properties() as $property) {
                $options[$property->id()] = $property->label();
            }
            if (!$options) {
                continue;
            }
            $valueOptions[] = [
                'label' => $vocabulary->label(),
                'options' => $options,
            ];
        }

        return $this->setValueOptions($valueOptions);
    }
}
