<?php

declare(strict_types=1);

namespace Light\Page\Controller;

use Dot\Controller\AbstractActionController;
use Laminas\Diactoros\Response\HtmlResponse;
use Light\Page\Service\PageServiceInterface;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;

class PageController extends AbstractActionController
{
    public function __construct(
        protected PageServiceInterface $pageService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template
    ) {
    }

    public function indexAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::home')
        );
    }

    public function homeAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::home', ['routeName' => 'home'])
        );
    }

    public function aboutUsAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::about')
        );
    }

    public function whoWeAreAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::who-we-are')
        );
    }
}
