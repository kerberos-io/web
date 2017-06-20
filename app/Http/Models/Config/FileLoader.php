<?php namespace App\Http\Models\Config;

class FileLoader extends Loader
{
    public function save($items, $environment, $group, $namespace = null)
    {
        $path = $this->getPath($namespace);

        if (is_null($path))
        {
            return;
        }

        $file = (!$environment || ($environment == 'production'))
            ? "{$path}/{$group}.php"
            : "{$path}/{$environment}/{$group}.php";

        $this->files->put($file, '<?php return ' . var_export($items, true) . ';');
    }
}
