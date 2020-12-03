<?php namespace App\ThirdParty;  

use \Melbahja\Seo\Factory;
use \Melbahja\Seo\Interfaces\MetaTagsInterface;

class VillageMeta extends Factory
{

    /**
     * Set a open graph tag
     *
     * @param  string $name
     * @param  string $value
     * @return MetaTagsInterface
     */
    public function fb(string $name, string $value): MetaTagsInterface
    {
        $this->og[] = ['meta', ['property' => "fb:{$name}", 'content' => $value]];
        return $this;
    }
}