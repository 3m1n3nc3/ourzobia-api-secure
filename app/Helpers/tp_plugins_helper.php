<?php

use \VStelmakh\UrlHighlight\UrlHighlight;
use \VStelmakh\UrlHighlight\Highlighter\HtmlHighlighter; 
use \VStelmakh\UrlHighlight\Encoder\HtmlSpecialcharsEncoder;
use \VStelmakh\UrlHighlight\Validator\Validator;

use \Endroid\QrCode\ErrorCorrectionLevel;
use \Endroid\QrCode\LabelAlignment;
use \Endroid\QrCode\QrCode;
use \Endroid\QrCode\Response\QrCodeResponse;

use App\ThirdParty\OpenGraph; 
use App\ThirdParty\VillageMeta; 
use App\Libraries\Creative_lib; 

use \Melbahja\Seo\Factory; 


if (! function_usable('linkFromText'))
{
    /**
     * Create click-able links from message
     */ 
    function linkFromText($text, $class = '') 
    {   
        if ($text === null) {
            return NULL;
        }
        // Decode link from #hashtags and @mentions
        return preg_replace(
            array(
                '/(^|[^a-z0-9_\/])@([a-z0-9_]+)/i', 
                '/(^|[^a-z0-9_\/])#(\w+)/u'
            ), 
            array(
                '$1<a class="'. $class .'" ' . site_url('user/profile/$2') .'" rel="loadpage">@$2</a>', 
                '$1<a class="'. $class .'" ' . site_url(urlencode('#').'$2').'" rel="loadpage">#$2</a>'
            ), 
            formatLinkFromText($text)
        ); 
    } 
}


if (! function_usable('local_check'))
{
    function local_check() 
    {  
        $domain_path    = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_FILENAME);
        $arr            = array("localhost","127.0.0.1","::1", $domain_path.".te", $domain_path.".test");
        if( in_array( $_SERVER['SERVER_NAME'], $arr ) )
        { 
            return true;
        }
        
        return false;
    }
}

if (! function_usable('formatLinkFromText'))
{
    /* 
    * Get a link from text
    */
    function formatLinkFromText($text, $class = 'text-danger') 
    { 
        if ($text === null) {
            return NULL;
        }
        // Decode the links
        $urlHighlighter = new HtmlHighlighter('http', ['class'=>$class]);
        $urlHighlight = new UrlHighlight(null, $urlHighlighter);
        return $urlHighlight->highlightUrls($text);

    }
} 


if (! function_usable('getLinkFromText'))
{
    /* 
    * Get a link from text
    */
    function getLinkFromText($text) 
    {  
        if ($text === null) {
            return NULL;
        }
        $urlHighlight = new UrlHighlight();
        $link = $urlHighlight->getUrls($text);
        return (!empty($link[0])) ? $link[0] : null;
    }
}


if (! function_usable('getOpenGraph'))
{
    /* 
    * Rad Open Graph data from the web and generate HTML code 
    * to publish your own Open Graph objects
    */
    function getOpenGraph($url, $save_image =  false) 
    { 
        if ($url == '') {
            return NULL;
        }
        // Decode the links  
        $graph = OpenGraph::fetch($url);

        if ($graph && stripos($graph->image, "?") !== false) 
        {
            $graph->image = substr($graph->image, 0, strpos($graph->image, "?"));
        }

        $data  = [
            'site_name' => $graph->site_name ?? ($graph->title ?? ''),
            'image' => $graph->image ?? '',
            'title' => $graph->title ?? '',
            'url' => $graph->url ?? '',
            'description' => $graph->description ?? ''
        ];

        if ($save_image === true && !empty($graph->image)) 
        {
            $creative = new Creative_lib;
            $data['file'] = $creative->saveRemoteFile($graph->image, true) ?? '';
            $data['file_name'] = $creative->saveRemoteFile($graph->image) ?? '';
        }

        if ($data['image'] && $data['title'])
        {
            return json_encode($data, JSON_FORCE_OBJECT);
        }
        return NULL;
    }
}


if (! function_usable('setOpenGraph'))
{
    /* 
    * Generate Open Graph tags
    */
    function setOpenGraph($data = []) 
    {   
        $creative = new Creative_lib;
        $metatags = Factory::metaTags();

        $metatags->meta('author', my_config('site_name'))
            ->meta('title', strip_tags($data['title'] ?? (my_config('site_name'))))
            ->meta('keywords', strip_tags(my_config('site_keywords')))
            ->meta('canonical', site_url())
            ->meta('description', strip_tags(decode_html(character_limiter($data['desc'] ??  my_config('site_description'), 200, ''))))
            ->image($data['image'] ?? $creative->fetch_image(my_config('default_banner')))  
            ->facebook('url', (!empty($data['url'])) ? $data['url'] : site_url())
            ->fb('app_id', my_config('fb_app_id'))
            ->facebook('type', 'website')
            ->facebook('site_name', my_config('site_name'))
            ->twitter('site',  '@' . preg_replace('/^.*\/\s*/', '', my_config('contact_twitter')))
            ->twitter('creator',  '@' . preg_replace('/^.*\/\s*/', '',my_config('contact_twitter')));

        if (!empty($data['robots'])) 
        {
            $metatags->meta('robots', $data['robots']);
        }
        return $metatags;
    }
}


if (! function_usable('verifyVideoLink'))
{
    /* 
    * Get a link from text
    */
    function verifyVideoLink($url) 
    { 
        $type = "";
 
        if(preg_match('/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/', $url, $vresult)) 
        {
            $type= 'youtube';
        } 
        elseif(preg_match('/(blip.tv)\/(file)\/([0-9]+)?/', $url, $vresult)) 
        {
            $type= 'bliptv';
        }  
        elseif(preg_match('/(break.com)\/(.*?)\.html/', $url, $vresult)) 
        {
            $type= 'break';
        }  
        elseif(preg_match('/(metacafe.com)\/(watch)\/(.*?)\/(.*?)\//', $url, $vresult)) 
        {
            $type= 'metacafe';
        }  
        elseif(preg_match('/(dailymotion.com)\/(video)\/(.*?)\//', $url, $vresult)) 
        {
            $type= 'dailymotion';
        }  

        return $type;
    }
}


if (! function_usable('qr_generator'))
{
    /* 
    * Generate a QR Code
    */
    function qr_generator($string = '', $label = '', $get = true) 
    { 
        $creative = new Creative_lib;

        // Create a basic QR code
        $qrCode = new QrCode($string);
        $qrCode->setSize(200);
        $qrCode->setMargin(10); 

        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('ISO-8859-1');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        if ($label) 
        {
            $qrCode->setLabel($label, 16,realpath(ROOTPATH . 'vendor').'/endroid/qr-code/assets/fonts/noto_sans.otf', LabelAlignment::CENTER());
        }
        $qrCode->setLogoPath($creative->fetch_image(my_config('site_logo'), 'logo'));
        $qrCode->setLogoSize(20, 20);
        $qrCode->setValidateResult(false);

        // Round block sizes to improve readability and make the blocks sharper in pixel based outputs (like png).
        // There are three approaches:
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary

        // Set additional writer options (SvgWriter example)
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]); 

        // // Save it to a file
        // $qrCode->writeFile(__DIR__.'/qrcode.png');

        // // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $qrCode->writeDataUri();
        if ($get == true) 
        {
            return $qrCode->writeDataUri();
        } 
    }
}


if (! function_usable('dec_increment'))
{
    /* 
    * get amount of decimals
    */
    function dec_increment($number) { 
$decimal = strlen(strrchr($number, '.')) -1; 

// Get amount to add
$increment = '.' . str_repeat('0', $decimal-1) . '1';

$number += $increment;

return $number;
    }
}