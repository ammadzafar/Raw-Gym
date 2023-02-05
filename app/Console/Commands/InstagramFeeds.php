<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Phpfastcache\Helper\Psr16Adapter;
use GuzzleHttp\Client;
use GuzzleHttp\Handler;
use  GuzzleHttp\Exception\ConnectException ;
use GuzzleHttp\Promise as P;
class InstagramFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'instagram:feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the instagram images on front end';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = env('INSTAGRAM_USERNAME');
        $password = env('INSTAGRAM_PASSWORD');

        if(!$username || !$password) {
            return $this->error('Please enter UserName and Password');
        }

        try {
          $instagram = \InstagramScraper\Instagram::withCredentials(new Client(), $username, $password, new Psr16Adapter('Files'));
            $instagram->login(); // will use cached session if you want to force login $instagram->login(true)
            $instagram->saveSession();  //DO NOT forget this in order to save the session, otherwise have no sense*/
//            $instagram = new \InstagramScraper\Instagram(new Client());
        $accountMedias = $instagram->getMedias($username);
           // $account = $instagram->getAccount($_ENV['INSTAGRAM_USERNAME']);
            //$accountMedias = $account->getMedias();


            $dir ='public/frontend/images/instagram/';
            $files =   Storage::allFiles($dir);
            Storage::delete($files);
            foreach ($accountMedias as $key => $accountMedia) {
                if ($key <= 8) {
                    $path = str_replace("&amp;", "&", $accountMedia->getimageHighResolutionUrl());
                    $image = file_get_contents($path);
                    Storage::put('public/frontend/images/instagram/image-' . $key . '.png', $image);
                }
            }
        }catch (Exception $exception)
        {
           $exception->getMessage();
        }




    }
}
