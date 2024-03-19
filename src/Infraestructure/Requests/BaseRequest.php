<?php
namespace App\Infraestructure\Requests;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    public function validate()
    {
        $isValidToken = $this->validateTokenRoute();

        $errors = $this->validator->validate($this);

        $messages = ['message' => 'validation_failed', 'errors' => []];

        if(!$isValidToken) {
            $messages['errors'][] = [
                'property' => 'Authorization',
                'value' => '',
                'message' => 'Access denied',
            ];

            $response = new JsonResponse($messages);
            $response->send();

            exit;
        }

        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages);
            $response->send();

            exit;
        }
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    private function validateTokenRoute()
    {
        $stack = new \SplStack();
        $indice = 0;

        if(!$this->getRequest()->headers->has('Authorization')) {
            return false;
        }

        $accessToken = substr($this->getRequest()->headers->get('Authorization'),7);

        while ($indice <= (strlen($accessToken)-1))
        {
            if($accessToken[$indice] === '{' || $accessToken[$indice] === '(' || $accessToken[$indice] === '[') {
                $stack->push($accessToken[$indice]);
            } else {
                if($stack->count() <= 0) {
                    return false;
                }
                $last = $stack->pop();
                if($last !== '{' && $accessToken[$indice] === '}') {
                    return false;
                }
                if($last !== '[' && $accessToken[$indice] === ']') {
                    return false;
                }
                if($last !== '(' && $accessToken[$indice] === ')') {
                    return false;
                }
            }
            $indice++;
        }

        if ($stack->count() > 0) {
            return false;
        }

        return true;
    }
}