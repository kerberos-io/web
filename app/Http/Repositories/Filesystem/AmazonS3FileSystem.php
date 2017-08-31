<?php namespace App\Http\Repositories\Filesystem;

use AWS, Config, Session, Auth;

use App\Http\Models\Filesystem\FileInterface as FileInterface;
use App\Http\Models\Filesystem\Image as Image;
use App\Http\Models\Cache\Cache as Cache;

class AmazonS3Filesystem implements FilesystemInterface
{
    protected $dynamoDB = null;
    protected $s3 = null;
    protected $bucket = null;
    protected $directory = null;
    protected $signingExpire; // in seconds (= 1 hour)

    public function __construct()
    {
        $this->user = Auth::user();

        //----------------------------------
        // Create s3 object and s3 endpoint

        $this->s3 = AWS::get('s3');
        $this->dynamoDB = AWS::get('dynamodb');
        $this->bucket = Config::get('app.filesystem.amazons3.bucket');
        $this->directory = Config::get('app.filesystem.amazons3.path');
        $this->signingExpire = Config::get('session.lifetime') * 300;
        $this->dynamoDBTimeout = Config::get('session.lifetime') * 300;
        $this->cache = new Cache($this->dynamoDBTimeout);
    }

    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function findAllImages()
    {
        //-----------------
        // Image array

        $images = [];

        //------------------------
        // Get objects from bucket

        $objects = $this->s3->getIterator('ListObjects', array('Bucket' => $this->bucket, 'Prefix' => $this->directory));
        foreach ($objects as $object)
        {
            //--------------------------------------------------
            // do check if object is an image and isn't to big..

            if($object['Size'] == 0) continue;

            $image = new Image;
            $image->setTimezone($this->timezone);
            $image->parse($object['Key']);
            array_push($images, $image);

        }

        return $images;
    }

    public function getPathToFile(FileInterface $file)
    {
         //-------------------------------------------------------------
        // Get session or create a new one for the signed url
        // The signed url will stay in session until it expire.
        // Afterwards a new request is sent to aws and it's cached again.

        $key = $file->getPath();

        $pathToFile = $this->cache->storeAndGet($key, function() use ($key)
        {
            $signedPath = $this->s3->getObjectUrl($this->bucket, $this->directory . $key, time() + $this->signingExpire);
            return $signedPath;
        });

        return $pathToFile;
    }

    public function getMetadata(FileInterface $file)
    {
        $metaData = $file->getMetadata();
        return $metaData;
    }
}
