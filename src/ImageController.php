<?php

namespace Jandanielcz\Positive;

use Laminas\Diactoros\Response;
use League\Glide\Server;
use League\Glide\Signatures\Signature;
use League\Glide\Signatures\SignatureException;
use League\Glide\Signatures\SignatureFactory;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImageController
{
    public function __construct(
        protected Server $glide,
        protected Configuration $configuration,
        protected Signature $signature
    ){}

    public function get(ServerRequestInterface $request): ResponseInterface
    {

        try {
            $path = $request->getUri()->getPath();
            $imagePath = str_replace('/image/', '', $path);
            $this->signature->validateRequest($path, $_GET);
            return $this->glide->getImageResponse($imagePath, $_GET);
        } catch (SignatureException $e) {
            $response = new Response();
            return $response->withStatus(401);
        }
    }
}