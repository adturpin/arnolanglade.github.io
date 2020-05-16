#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

$environment = Environment::createCommonMarkEnvironment();
$environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer());
$environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer());

$commonMarkConverter = new CommonMarkConverter([], $environment);

$buildPath = __DIR__ . '/../build/';

$filesystem = new Filesystem();
$filesystem->remove($buildPath);

$posts = (new Finder())
    ->files()
    ->in(__DIR__ . '/../post/')
    ->name('*.md');

$postNames = [];
foreach ($posts as $post) {
    $postNames[] = $post->getFilenameWithoutExtension();
    $filesystem->appendToFile(
        $buildPath.$post->getFilenameWithoutExtension().'.html',
        $commonMarkConverter->convertToHtml($post->getContents())
    );
}

ob_start();
require __DIR__ .'/../post/index.php';
$listOfPosts =  ob_get_clean();

$filesystem->appendToFile(
    $buildPath.'index.html',
    $listOfPosts
);