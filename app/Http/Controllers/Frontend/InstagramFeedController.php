<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Doctrine\DBAL\Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Phpfastcache\Helper\Psr16Adapter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InstagramFeedController extends Controller
{
 public function index()
 {
     try {
         $instagram = new \InstagramScraper\Instagram(new Client());
         $accountMedias = $instagram->getMedias('scriptsbundle60');

         foreach ($accountMedias as $key  => $accountMedia) {
             $path = str_replace("&amp;","&", $accountMedia->getimageHighResolutionUrl());
             $image = file_get_contents($path);
             dump($accountMedia);
             Storage::put('public/frontend/images/  instagram/image-' . $key . '.png', $image);
         }

     } catch (HttpException $exception)
     {
         dd($exception->getMessage());
//         return view('frontend.index',[$exception->getMessage()]);
     }

     dd('true');

     return view('frontend.index');
 }

}
