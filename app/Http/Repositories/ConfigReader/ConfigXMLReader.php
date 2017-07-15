<?php namespace App\Http\Repositories\ConfigReader;

use SimpleXMLElement as SimpleXMLElement;
use Illuminate\Filesystem\Filesystem as Filesystem;

class ConfigXMLReader implements ConfigReaderInterface
{
    public function read($xml)
    {
        return $this->readXML($xml);
    }

    public function readXML($xml)
    {
        $config = [];

        $filesystem = new Filesystem();
        if($filesystem->exists($xml))
        {
            $content = $filesystem->get($xml);
            $config = new SimpleXMLElement($content);
        }

        return $config;
    }

    public function isValidXML($xml)
    {
        try
        {
            $xml = new SimpleXMLElement($xml);
            return true; //this is valid
        }
        catch(Exception $e)
        {
            return false; //this is not valid
        }
    }

    public function parse($xml)
    {
        $tree = [];
        if($xml != '')
        {
            $this->parseConfig($tree, $xml . "/config.xml");
        }
        return $tree;
    }

    public function parseConfig(&$tree, $xml)
    {
        $config = $this->readXML($xml);
        if(count($config) > 0)
        {
            $this->parseChildren($tree, $config, $xml, "");
        }
    }

    public function save($directory, $settings)
    {
        $configs = $this->getConfigs($directory);

        foreach($settings as $name => $setting)
        {
            // ---------------------
            // Replace space by dash

            $setting = str_replace(' ', '-', rtrim(ltrim($setting, ' '), ' '));

            $parts = explode("__", $name);
            if(array_key_exists($parts[0], $configs))
            {
                $element = &$configs[$parts[0]];
                for($i = 1; $i < count($parts)-1; $i++)
                {
                    if(array_key_exists($parts[$i], $element))
                    {
                        $element = &$element->{$parts[$i]};
                    }
                }

                if(array_key_exists($parts[count($parts)-1], $element))
                {
                    $element->{$parts[count($parts)-1]} = $setting;
                }
            }
        }

        foreach($configs as $key => $config)
        {
            // --------------------------------------------
            // Check if configs are valid, before saving it

            $string = $config->asXML();
            if($this->isValidXML($string))
            {
                $config->saveXML($directory . "/" . $key . ".xml");
            }
        }
    }

    public function getConfigs($directory)
    {
        $configs = [];
        $filesystem = new Filesystem();
        if($filesystem->exists($directory))
        {
            $files = $filesystem->files($directory);
            foreach ($files as $key => $file)
            {
                $configParts = explode("/", $file);
                $configName = explode(".", $configParts[count($configParts)-1]);
                $configName = $configName[0];
                $configs[$configName] = $this->readXML($file);
            }
        }
        return $configs;
    }

    public function parseChildren(&$tree, $config, $configFile, $name)
    {
        $tree = [];

        $configParts = explode("/", $configFile);
        $configName = explode(".", $configParts[count($configParts)-1]);
        $configName = $configName[0];

        foreach($config->children() as $element => $item)
        {
            $attributes = [];

            foreach ($item->attributes() as $key => $attribute)
            {
                $value = (string) $attribute;
                $child = [
                    "key" => $key,
                    "value" => $value
                ];

                // -----------------------------------
                // If pointing to another XML, load it

                if($key == "file")
                {
                    $tree[$item->getName()]["dropdown"] = [];

                    $directory = str_replace($configParts[count($configParts)-1], "", $configFile);
                    $xmlToLoad = $directory . "/" . $value;

                    $child["file"] = $configName;
                    $this->parseConfig($tree[$item->getName()]["dropdown"], $xmlToLoad, "");
                }
                array_push($attributes, $child);
            }

            $tree[$item->getName()]["attributes"] = $attributes;

            if($item->count() > 0)
            {
                // ------------
                // If a wrapper

                if(count($attributes) == 0 && $name != "")
                {
                    $element = $name . "__" . $element;
                }

                $this->parseChildren($tree[$item->getName()]["children"], $item, $configFile, $element);
            }
            else
            {
                $tree[$item->getName()]["file"] = $configName;
                $tree[$item->getName()]["attribute"] = $name . "__" . $element;
                $tree[$item->getName()]["value"] = (string) $item;
            }
        }
    }
}
