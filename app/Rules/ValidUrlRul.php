<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ValidUrlRul implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Validate if the given value is a valid url
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new Client();
        $response = $client->get($value, ["http_errors" => false]);
        return $response->getStatusCode() == Response::HTTP_OK || $response->getStatusCode() == Response::HTTP_CREATED;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given url is not available.';
    }
}
