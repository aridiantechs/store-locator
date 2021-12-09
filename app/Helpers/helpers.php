<?php

use Carbon\Carbon;
use App\Content;
use App\Language;
use App\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 

/**
 * Created by PhpStorm.
 * User: CreatyDev
 * Date: 12/29/2017
 * Time: 1:30 AM
 */

CONST PRODUCT_IMAGE_PATH = 'public/uploads/product';
CONST USER_IMAGE_PATH = 'public/uploads/users';
CONST TICKETS_IMAGE_PATH = 'public/uploads/users';
CONST USER_IMAGE_PATH_PUBLIC = '/storage/uploads/users/';

if (!function_exists('currency_icon')) {
    /**
     * Check's whether request url/route matches passed link
     *
     * @param $link
     * @param string $type
     * @return null
     */
    function currency_icon()
    {
         
        return "$";
    }
}

if (!function_exists('on_page')) {
    /**
     * Check's whether request url/route matches passed link
     *
     * @param $link
     * @param string $type
     * @return null
     */
    function on_page($link, $type = "name")
    {
        switch ($type) {
            case "url":
                $result = ($link == request()->fullUrl());
                break;

            default:
                $result = ($link == request()->route()->getName());
        }

        return $result;
    }
}

if (!function_exists('return_if')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function return_if($condition, $value)
    {

        if ($condition) {
            return $value;
        }
    }
}

if (!function_exists('makeId')) {
    
    function makeId($value)
    {

        if ($value) {
            return str_replace(" ", "_", $value);
        }
        return '';
    }
}

// Custom Helpers by Nisar Ahmed
// if (!function_exists('unique_string')) {
//     /**
//      * Generate Unique String with Model
//      *
//      * @param $condition
//      * @param $value
//      * @return null
//      */
//     function unique_string($table,$key, $length = 8,$numbers = false)
//     {   
//         if($numbers){
//             $unique_id = "10".mt_rand(100000000000, 999999999999);
//         }else{
//             $unique_id = \Illuminate\Support\Str::random($length);
//         }
        

//         $d = \DB::table($table)->where($key,$unique_id)->first();
//         if($d){
//             if($numbers){
//                 $this->unique_string($table,$key,$length,true);
//             }else{
//                 $this->unique_string($table,$key,$length);
//             }
            
//         }else{
//             return $unique_id;
//         }

//     }
// }



if (!function_exists('text_format')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function text_format($val)
    {   
        return str_replace('_', ' ', ucwords($val));
    }
}



if (!function_exists('custom_file_upload'))
{
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function custom_file_upload($file, $path = 'uploads', $slug = null, $default = 'default.jpg')
    {
        if (isset($file))
        {
            $currentDate = Carbon::now()->toDateString();
            $image_name = $slug . '-' . $currentDate .'-'.uniqid(). '.' . $file->getClientOriginalExtension();

        

            $path = Storage::putFileAs($path, $file, $image_name);
            if ($path)
            {
                return $image_name;
            }
        }
        else
        {
            return $default;
        }

    }
}

if (!function_exists('success')) {
    /**
     * // Success Message
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function success($msg)
    {   
        return request()->session()->flash('success',$msg);
    }
}

if (!function_exists('error')) {
    /**
     * // Error Message
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function error($msg)
    {   
        return request()->session()->flash('error',$msg);
    }
}

if (!function_exists('currencyOld')) {
    
    function currencyOld($currency = null, $symbol = null)
    {   
        if($currency && $currency != 'free' && $currency >= 0)
        {
            // $apikey = '0b7cfc6702c818f990cb';
            // $from_Currency = urlencode('USD');
            // $to_Currency = urlencode(auth()->user()->default_currency ?? session('currency') ?? 'USD');
            // $query =  "{$from_Currency}_{$to_Currency}";

            // if(!cache('exchange_rate') || cache('to_Currency') !== $to_Currency){
            //     $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
                
            //     $obj = json_decode($json, true);

            //     $exchange_rate = floatval($obj["$query"]);

            //     cache(['exchange_rate' => $exchange_rate], now()->addMinutes(10));
            //     cache(['to_Currency' => $to_Currency], now()->addMinutes(10));
            //     // Session(['exchange_rate' => $exchange_rate]);
            // }
            // else
            //     $exchange_rate = cache('exchange_rate');

            // if($to_Currency == 'USD' || $to_Currency == 'AUD' || $to_Currency == 'CAD')
            //     $currency_sign = '$';
            // else if($to_Currency == 'EUR')
            //     $currency_sign = '€';
            // else if($to_Currency == 'GBP')
            //     $currency_sign = '£';
            // else
            //     $currency_sign = '';
            // if($symbol)
            //     return $currency_sign . ' ' . number_format((float)($currency * $exchange_rate), 2, '.', '');

            // // .  ' ' . $to_Currency
            // return number_format((float)($currency * $exchange_rate), 2, '.', '');
            return $currency;
        }elseif($currency == 'free'){
            return '0.00';
        }
        else
        {
            if (Auth::user()) {
                return auth()->user()->default_currency ?? 'USD';
            } else {
                return session('currency') ?? 'USD';
            }
        }
    }
}

if (!function_exists('api_response')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function api_response($data,$status = 200,$message = "",$errors = [] )
    {       

        if($status == 200){
            $status = "1";
        }elseif($status == 0){
            $status = "0";
        }else{
            $status = "X";
        }
        return response()->json([    
            'header' => [
                'return_flag' => $status,
                'error_detail' => $message ?? "",
                'errors' => !empty($errors) ? $errors : [],
            ],
            'data' => $data,
        ]);
    }
}

if (!function_exists('stripe_fee')) {
    /**
     * // stripe_fee
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function stripe_fee($amount)
    {   
        return ((2.9/100) * $amount) + 0.30;
    }
}

if (!function_exists('api_response_status')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function api_response_status($data,$status = 200,$message = "",$errors = [] )
    {   
        return response()->json([    
            'header' => [
                'return_flag' => ($status == 200) ? "1" : "X",
                'error_detail' => $message ?? "",
                'errors' => !empty($errors) ? $errors : (object)[],
                'status' => $status,
            ],
            'data' => $data,
        
        ]);
    }
}


  function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }






if (!function_exists('limitText')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */


    function limitText($string = null){
        $string = strip_tags($string);

        if (strlen($string) > 100) {

            // truncate string
            $stringCut = substr($string, 0, 100);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '... ';
        }

        return $string;
    }
}



if (!function_exists('language')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */


    function language($language = null, $code = null){

        $lang      = user()->language->name       ?? session('language')      ?? Language::first()['name']       ?? 'English';
        $lang_code = user()->language->short_form ?? session('short_form') ?? Language::first()['short_form'] ?? 'EN';
        
        if(is_null($language) && is_null($code))
            $response =  $lang . ' (' . $lang_code . ')';
        else
            $response =  $lang;

        return $response;
    }
}



if (!function_exists('currency')) {
    /**
     * // Check if Property Exists then Echo it
     *
     * @param $condition
     * @param $value
     * @return null
     */


    function currency($currency = null, $code = null){

        $currency_value = user()->currency->name           ?? session('currency')      ?? Currency::first()['name']       ?? 'Dollar';
        $currency_code  = user()->currency->short_form ?? session('short_form') ?? Currency::first()['short_form'] ?? 'USD';

        // dd($currency_value,$currency_code); 
        
        if(is_null($currency) && is_null($code))
            $response =  $currency_value . ' (' . $currency_code . ')';
        else
            $response =  $currency_value;

        return $response;
    }
}


// Custom Helpers for unique string
if (!function_exists('unique_string')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function unique_string($table,$key, $length)
    {   
        $unique_id = \Illuminate\Support\Str::random($length);
        $d = \DB::table($table)->where($key,$unique_id)->first();
        if($d){
            $this->unique_string($table,$key,$length);
        }else{
            return $unique_id;
        }

    }
}



// Custom Helpers for site logo
if (!function_exists('site_logo')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function site_logo()
    {   
        
        $logo = \App\Content::where('page', 'header')->where('type', 'header-logo')->pluck('value')->first();
        return $logo['header_logo_input'] ?? 'backend_assets/site_assets/images/logo/logo.png';

    }
}





// Custom Helpers for app name
if (!function_exists('app_name')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function app_name()
    {   
        return config('app.name', 'Laravel');
    }
}





// Custom Helpers for default image
if (!function_exists('default_image')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function default_image()
    {   
        return 'admin/images/rec2.jpg';
    }
}

// Custom Helpers for slug
if (!function_exists('slugify')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    
    function slugify($var, $table = null)
    {
        $slug = $var;
        // replace non letter or digits by -
        $slug = preg_replace('~[^\pL\d]+~u', '-', $slug);

        // transliterate
        $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);

        // remove unwanted characters
        $slug = preg_replace('~[^-\w]+~', '', $slug);

        // trim
        $slug = trim($slug, '-');

        // remove duplicate -
        $slug = preg_replace('~-+~', '-', $slug);

        // lowercase
        $slug = strtolower($slug);

        if($table){

            $exist = \DB::table($table)->where('slug', $slug)->first();
            if($exist){
                slugify($var . ' ' . mt_rand(100,1000) . ' ' . time(),$table);
            }
        }

        if (empty($slug)) {
            return 'n-a';
        }

        return $slug;
    }
}



// Custom Helpers for auth user id
if (!function_exists('user')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    
    function user($var = null)
    {
        if($var == 'id')
            return auth()->user()->id;
        else if($var == 'name')
            return auth()->user()->name;
        else if($var == 'farm_id')
            return auth()->user()->farm_id;
        else
            return auth()->user();
    }
}


if (!function_exists('beautify')) {
    /**
     * Generate Unique String with Model
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function beautify($string = '')
    {   
        return str_replace('_', ' ', preg_replace('/(?<=[a-z])[A-Z]|[A-Z](?=[a-z])/', ' $0', preg_replace('/[0-9]+/', '', $string)));
    }
}

if (!function_exists('stripe_fee'))
{
    /**
     * // stripe_fee
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function stripe_fee($amount)
    {
        return ((2.9 / 100) * $amount) + 0.30;
    }
}

if (!function_exists('currencyToCent')) {
    function currencyToCent($value):
    int
    {
        return (int)(string)((float)preg_replace("/[^0-9.]/", "", $value) * 100);
    }
}

if (!function_exists('amountToUsd')) {
    function amountToUsd($value)    
    {
        return (double)(string)((double)preg_replace("/[^0-9.]/", "", $value) / 100);
    }
}

if (!function_exists('searchForStatus')) {
    function searchForStatus($status, $group_array) {
        $found=array();
        foreach ($group_array as $vendor => $array) {
            
            foreach ($array as $key => $val) {
                if ($val['status'] === $status) {
                    /* dd($vendor); */
                    array_push($found,$vendor);
                    /* return $key; */
                }
            }
            
        }
        return $found;
     }
}

if (!function_exists('getImage')) {
    
    function getImage($path = null, $type = null, $class = null)
    {
        $default = null;

        switch ($type) {
            case 'post':
                $default = asset('uploads/default/generic-post.png');
                break;
            
            case 'product':
                $default = asset('uploads/default/generic-product.png');
                break;
            
            case 'farm':
                $default = asset('uploads/default/farmer-thumb-1.jpg');
                break;
            
            case 'post-banner':
                $default = asset('uploads/default/single-blog.jpg');
                break;
            
            case 'post-thumb':
                $default = asset('uploads/default/post-thumb.jpg');
                break;
            
            case 'product-banner':
                $default = asset('uploads/default/generic-post.png');
                break;
            
            case 'farm-banner':
                $default = asset('uploads/default/generic-post.png');
                break;
            
            default:
                $default = asset('uploads/default/generic-post.png');
                break;
        }


        if($path !== null && File::exists($path))
            return "<img src='".asset($path)."' class='img img-fluid ". $class ."' >";
        else
            return "<img src='".$default."' class='img img-fluid ". $class ."' >";
        
    }

}


if (!function_exists('printTruncated')) {
    
    function printTruncated($maxLength, $html, $isUtf8=true)
    {
        $printedLength = 0;
        $position = 0;
        $tags = array();

        // For UTF-8, we need to count multibyte sequences as one character.
        $re = $isUtf8
            ? '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;|[\x80-\xFF][\x80-\xBF]*}'
            : '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}';

        while ($printedLength < $maxLength && preg_match($re, $html, $match, PREG_OFFSET_CAPTURE, $position))
        {
            list($tag, $tagPosition) = $match[0];

            // Print text leading up to the tag.
            $str = substr($html, $position, $tagPosition - $position);
            if ($printedLength + strlen($str) > $maxLength)
            {
                print(substr($str, 0, $maxLength - $printedLength));
                $printedLength = $maxLength;
                break;
            }

            print($str);
            $printedLength += strlen($str);
            if ($printedLength >= $maxLength) break;

            if ($tag[0] == '&' || ord($tag) >= 0x80)
            {
                // Pass the entity or UTF-8 multibyte sequence through unchanged.
                print($tag);
                $printedLength++;
            }
            else
            {
                // Handle the tag.
                $tagName = $match[1][0];
                if ($tag[1] == '/')
                {
                    // This is a closing tag.

                    $openingTag = array_pop($tags);
                    assert($openingTag == $tagName); // check that tags are properly nested.

                    print($tag);
                }
                else if ($tag[strlen($tag) - 2] == '/')
                {
                    // Self-closing tag.
                    print($tag);
                }
                else
                {
                    // Opening tag.
                    print($tag);
                    $tags[] = $tagName;
                }
            }

            // Continue after the tag.
            $position = $tagPosition + strlen($tag);
        }

        // Print any remaining text.
        if ($printedLength < $maxLength && $position < strlen($html))
            print(substr($html, $position, $maxLength - $printedLength));

        // Close any open tags.
        while (!empty($tags))
            printf('</%s>', array_pop($tags));
    }

}


