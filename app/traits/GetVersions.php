<?php namespace App\Traits;

use Auth, Config, Guzzle\Http\Client as Client;
use App\Http\Models\Cache\Cache as Cache;
use Input, Session;

trait GetVersions
{
    public function isUpdateAvailable()
    {
        $currentVersion = $this->getCurrentVersion();

        if($currentVersion)
        {
            $versions = [];

            try
            {
                $versions = $this->getVersionsFromGithub();
            }
            catch(\Exception $e){}

            if(count($versions) > 0)
            {
                $latestVersion = array_reverse($versions)[0]['version'];
                return ($currentVersion !== $latestVersion);
            }
        }

        return false;
    }

    public function getCurrentVersion()
    {
        $cmd = 'cat /etc/version';
        $version = shell_exec($cmd);
        preg_match('/os_version="(.*?)"/', $version, $matches);

        if(count($matches) > 0)
        {
            return 'v' . $matches[1];
        }

        return null;
    }

    public function getVersionsFromGithub()
    {
        // -------------------------------------
        // Cache images directory for x seconds

        $cache = new Cache(Config::get('session.lifetime'));

        $user = Auth::user();
        $key = $user->username . "_kios_versions";

        if(Input::get('develop'))
        {
            Session::forget($key);
        }

        $versions = $cache->storeAndGet($key, function()
        {
            try
            {
                $url = "https://api.github.com/repos/kerberos-io/kios/releases";
                if(Input::get('develop'))
                {
                    $url = "https://api.github.com/repos/cedricve/kios/releases";
                }

                $client = new Client();
                $request = $client->get($url);
                $response = $client->send($request);
                $body = json_decode($response->getBody());

                $versions = [];
                for($i = 0; $i < count($body); $i++)
                {
                    array_push($versions, [
                        'version' => $body[$i]->tag_name,
                        'name' => $body[$i]->name,
                        'body' => $body[$i]->body,
                        'prerelease' => $body[$i]->prerelease,
                        'assets' => $body[$i]->assets,
                        'published_at' => $body[$i]->published_at
                    ]);
                }

                $versions = array_values(array_sort($versions, function($value)
                {
                    return $value['version'];
                }));
            }
            catch(\Exception $ex)
            {
                $versions = [];
            }

            return $versions;
        });

        return $versions;
    }
}
