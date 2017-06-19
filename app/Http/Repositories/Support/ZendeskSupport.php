<?php namespace App\Http\Repositories\Support;

use Config, Guzzle\Http\Client as Client;
use Carbon\Carbon as Carbon;

class ZendeskSupport implements SupportInterface
{
    public function getArticles($count = 7)
    {
        $articles = [];

        try
        {
            // Get ID of the Announcements section
            $url = 'https://kerberosio.zendesk.com/api/v2/help_center/sections.json';
            $client = new Client();
            $request = $client->get($url);
            $response = $client->send($request);
            $body = json_decode($response->getBody());
            $body = $body->sections;

            $id = null;
            for($i = 0; $i < count($body); $i++)
            {
                if($body[$i]->name == 'Announcements')
                {
                    $id = $body[$i]->id;
                    break;
                }
            }

            if($id != null)
            {
                // Get all articles and filter on announcement
                $url = "https://kerberosio.zendesk.com/api/v2/help_center/articles/search.json?query=&section=$id";
                $request = $client->get($url);
                $response = $client->send($request);
                $body = json_decode($response->getBody());
                $body = $body->results;

                for($i = 0; $i < count($body); $i++)
                {
                    array_push($articles, [
                        'title' => $body[$i]->title,
                        'timestamp' => Carbon::parse($body[$i]->created_at)->timestamp,
                        'date' => Carbon::parse($body[$i]->created_at)->formatLocalized('%d %B %Y'),
                        'body' => $body[$i]->body,
                        'url' => $body[$i]->html_url
                    ]);
                }

                usort($articles, function($a, $b)
                {
                    return strcmp($a['timestamp'], $b['timestamp']);
                });
            }

            if($count > count($articles))
            {
                $count = count($articles);
            }

            $articles = array_reverse($articles);
            $articles = array_slice($articles, 0, $count);
        }
        catch (\Exception $e) {}

        return $articles;
    }
}
