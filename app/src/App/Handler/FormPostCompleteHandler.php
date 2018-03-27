<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entities;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Template;

class FormPostCompleteHandler implements RequestHandlerInterface
{
    private $template;

    public function __construct(Template\TemplateRendererInterface $template) {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);

        return new HtmlResponse($this->template->render(
            'app::form-complete',
            ['flashMessages' => $flashMessages]
        ));
    }
}
