<?php

namespace Awcodes\Documental;

use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\Node\TableOfContents;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\Node\Query;
use League\CommonMark\Renderer\HtmlRenderer;
use Phiki\Adapters\CommonMark\PhikiExtension;
use PomoDocs\CommonMark\Alert\AlertExtension;
use RyanChandler\CommonmarkBladeBlock\BladeExtension;

class Documental
{
    /** @throws CommonMarkException */
    public function markdown(string $string): array
    {
        $options = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'apply_id_to_heading' => true,
                'heading_class' => '',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 2,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => '#',
                'aria_hidden' => true,
            ],
            'table_of_contents' => [
                'html_class' => 'table-of-contents',
                'position' => 'top',
                'style' => 'bullet',
                'min_heading_level' => 2,
                'max_heading_level' => 3,
                'normalize' => 'relative',
                'placeholder' => null,
            ],
            'alert' => [
                'class_name' => 'alert',
                'colors' => [
                    'note' => 'note',
                    'tip' => 'tip',
                    'important' => 'important',
                    'warning' => 'warning',
                    'caution' => 'caution',
                ],
                'icons' => [
                    'active' => true,
                    'use_svg' => true,
                ],
            ],
        ];

        $extensions = [
            new HeadingPermalinkExtension,
            new TableOfContentsExtension,
            new PhikiExtension([
                'light' => config('documental.phiki.themes.light'),
                'dark' => config('documental.phiki.themes.dark'),
            ]),
            new BladeExtension,
            new AlertExtension,
        ];

        $converter = new GithubFlavoredMarkdownConverter($options);
        $environment = $converter->getEnvironment();

        foreach ($extensions as $extension) {
            $environment->addExtension($extension);
        }

        $converted = $converter->convert($string);

        $document = $converted->getDocument();

        $toc = (new Query)
            ->where(Query::type(TableOfContents::class))
            ->findOne($document);

        $toc?->detach();

        $renderer = new HtmlRenderer($environment);

        return [
            'content' => $renderer->renderDocument($document),
            'toc' => $toc ? $renderer->renderNodes([$toc]) : '',
        ];
    }
}
