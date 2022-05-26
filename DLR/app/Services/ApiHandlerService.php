<?php
namespace App\Services;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;


class Bla{
protected $type;
protected $url;
protected $values;
public function __construct(String $type, String $url, String $values)
{
    $this->type = $type;
    $this->url = $url;
    $this->values = $values;
}
public function requesthandler()
{   
    if ($this->type == 'Post') {
        return $this->PostApi();
    } else {
        return $this->GetApi();
    }
}
public function PostApi()
{
    $jsonobject = json_decode($this->values);
    $post_response = Http::post($this->url, $jsonobject);
    return $post_response;
}
public function GetApi()
{
    $jsonobject = json_decode($this->values);
    $getvariables = "";
    $numvalues = 0;
    foreach ($jsonobject as $key => $value) {
        $numvalues=$numvalues+1;
    }
    $i = 0;
    foreach ($jsonobject as $key => $value) {
        if (++$i === $numvalues) {
            $getvariables .= $key . "=" . $value;
        } else {
            $getvariables .= $key . "=" . $value . "&";
        }
    }
    $getresponse = Http::get(
        $this->url . $getvariables
    );
    return $getresponse;
}
}
