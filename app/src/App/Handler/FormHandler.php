<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class FormHandler implements RequestHandlerInterface
{
    private $template;

    public function __construct(Template\TemplateRendererInterface $template) {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [];


        return new HtmlResponse($this->template->render('app::form', $data));
    }
}
