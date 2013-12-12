<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace CkeditorModule\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use CmsModule\Content\Forms\Controls\Events\ContentEditorArgs;
use CmsModule\Content\Forms\Controls\Events\ContentEditorEvents;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class FormaterListener implements EventSubscriber
{

	/** @var string */
	protected $basePath;

	/** @var \Nette\DI\Container */
	protected $context;


	/**
	 * @param \Nette\DI\Container|\SystemContainer $context
	 */
	public function __construct(\Nette\DI\Container $context)
	{
		$this->context = $context;
		$this->basePath = $context->parameters['basePath'];
	}


	/**
	 * Array of events.
	 *
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return array(
			ContentEditorEvents::onContentEditorLoad,
			ContentEditorEvents::onContentEditorSave,
			ContentEditorEvents::onContentEditorRender,
		);
	}


	public function onContentEditorLoad(ContentEditorArgs $args)
	{
		$value = $args->getValue();

		$value = preg_replace(array_keys($this->getPatternsLoad()), array_merge($this->getPatternsLoad()), $value);

		$args->setValue($value);
	}


	public function onContentEditorSave(ContentEditorArgs $args)
	{
		$value = $args->getValue();

		$value = preg_replace(array_keys($this->getPatternsSave()), array_merge($this->getPatternsSave()), $value);

		$args->setValue($value);
	}


	public function onContentEditorRender(ContentEditorArgs $args)
	{
		$value = $args->getValue();
		$presenter = $this->context->application->getPresenter();

		$snippetMode = $presenter->snippetMode;
		$presenter->snippetMode = NULL;
		$template = $presenter->createTemplate('Nette\Templating\Template');
		$template->setSource($value);

		$args->setValue($template->__toString());
		$presenter->snippetMode = $snippetMode;
	}


	protected function  getPatternsLoad()
	{
		return array(
			'/(<img[^>]*)n:src="([^ "]*)[ ]*,[ ]*size=>\'([^x]*)x([^\']*)\'[^"]*"/' => '${1}src="{$basePath}/public/media/${2}" style="width: ${3}px; height: ${4}px;"',
			'/(<a[^>]*)n:fhref="([^ "]*)"/' => '${1}href="{$basePath}/public/media/${2}"',
			'/src="{\$basePath}\//' => 'src="' . $this->basePath . '/',
			'/href="{\$basePath}\//' => 'href="' . $this->basePath . '/',
		);
	}


	protected function  getPatternsSave()
	{
		return array(
			'/src="' . str_replace("/", "\/", $this->basePath) . '\//' => 'src="{$basePath}/',
			'/href="' . str_replace("/", "\/", $this->basePath) . '\//' => 'href="{$basePath}/',
			'/(<img[^>]*)src="\{\$basePath\}\/public\/media\/([^"]*)"([ ]*)style="([ ]*(?:width:[ ]*(\d+)px;[ ]*)*(?:height:[ ]*(\d+)px;[ ]*)*(?:width:[ ]*(\d+)px[;]*[ ]*)*)"[ ]*/' => '${1}n:src="${2}, size=>\'${5}${7}x${6}\', format=>\Nette\Image::STRETCH" style="${4}" ',
			'/(<a[^>]*)href="\{\$basePath\}\/public\/media\/([^"]*)"/' => '${1}n:fhref="${2}"',
		);
	}
}
