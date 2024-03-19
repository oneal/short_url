<?php
namespace App\Infraestructure\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ApiShortUrlRequest  extends BaseRequest
{
    #[Type('string')]
    #[NotBlank()]
    protected $url;
}