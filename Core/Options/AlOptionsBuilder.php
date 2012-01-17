<?php
/*
 * This file is part of the AlValumUploaderBundle and it is distributed
 * under the MIT License. To use this bundle you must leave
 * intact this copyright notice.
 *
 * (c) Since 2011 AlphaLemon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://alphalemon.com
 * 
 * @license    MIT License
 */

namespace AlphaLemon\AlValumUploaderBundle\Core\Options;

use Symfony\Component\HttpFoundation\Request;

abstract class AlOptionsBuilder
{
    protected $_container = null;
    protected $_request = null;
    protected $_options = array();
    protected $_customOptions = array();

    public function __construct($container)
    {
        $this->_container = $container;
        $this->_request = $this->_container->get('request');
    }

    public abstract function configure(AlOptionsMapper $mapper);

    protected function inCustomOptions($optionName)
    {
        if(array_key_exists($optionName, $this->_customOptions))
        {
            return $this->_customOptions[$optionName];
        }

        return null;
    }

    protected function inRequest($optionName)
    {
        if($this->_request->get($optionName) != null)
        {
            return $this->_request->get($optionName);
        }

        return null;
    }

    protected function inParameters($optionName, array $defaultValues)
    {
        if($this->_container->hasParameter($defaultValues["parameterName"]))
        {
            $defaultValue = $defaultValues["parameterName"];
            $parameterValue = $this->_container->getParameter($defaultValue); 
            if(is_array($parameterValue))
            {
                if(count($parameterValue) > 0)
                {
                    $params = array();
                    foreach($parameterValue as $key => $value)
                    {
                        $v = $this->inCustomOptions($key);
                        if(null === $v)
                        {
                            $v = $this->inRequest($key);
                            if(null === $v)
                            {
                                $v = $value;
                            }
                        }

                        $params[] = sprintf("%s: '%s'", $key, $v); 
                    }
                    return implode(",", $params);
                }
                else
                {
                    return "";
                }
            }
            else
            {
                return $parameterValue;
            }
        }

        return null;
    }

    protected function setValue($optionName, array $defaultValues)
    {
        $value = $this->inCustomOptions($optionName);
        if(null === $value)
        {
            $value = $this->inRequest($optionName);
            if(null === $value)
            {
                $value = $this->inParameters($optionName, $defaultValues);
                if(null === $value)
                {
                    $value = $defaultValues["defaultValue"];
                }
            }
        }

        return $value;
    }

    public function getOptions()
    {
        return $this->_options;
    }

    public function build(array $customOptions = array())
    {
        $this->_customOptions = $customOptions;

        $mapper = new AlOptionsMapper();
        $this->configure($mapper);
        foreach($mapper->getOptions() as $optionName => $optionValues)
        {
            $this->_options[$optionName] = $this->setValue($optionName, $optionValues);
        }
    }
}

class AlOptionsMapper
{
    protected $_options = array();

    public function add($optionName, $parameterName, $defaultValue = "")
    {
        if(array_key_exists($optionName, $this->_options))
        {
            throw new InvalidArgumentException($this->translate("The option %optionName% already exists in the mappaing", array('optionName' => $optionName)));
        }

        $this->_options[$optionName] = array("parameterName" => $parameterName, "defaultValue" => $defaultValue);
    }

    public function remove($optionName)
    {
        if(!array_key_exists($optionName, $this->_options))
        {
            throw new InvalidArgumentException($this->translate("The option %optionName% does not exist anymore in the mappaing", array('optionName' => $optionName)));
        }

        unset($this->_options[$optionName]);
    }
    public function getOptions()
    {
        return $this->_options;
    }


    public function getParameterName($optionName)
    {
        return $this->_options[$optionName]["parameterName"];
    }

    public function getDefaultValue($optionName, $parameterName)
    {
        return $this->_options[$optionName]["defaultValue"];
    }

    protected function translate($message)
    {
        return $this->_container->get('translator')->trans($message);
    }
}
