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
use CoreModule\Content\Forms\Controls\Events\ContentEditorArgs;
use CoreModule\Content\Forms\Controls\Events\ContentEditorEvents;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class FormaterListener implements EventSubscriber
{

	/** @var string */
	protected $basePath;

	function __construct(\Nette\DI\Container $context)
	{
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


	protected function  getPatternsLoad()
	{
		return array(
			'/src="{\$basePath}\//' => 'src="' . $this->basePath . '/',
			'/href="{\$basePath}\//' => 'href="' . $this->basePath . '/',
			//'/{=\'([^\']*)\'[ ]*?[|][ ]*?resize:[^\}]*}/i' => '${1}',
		);
	}

	protected function  getPatternsSave()
	{
		return array(
			'/src="' . str_replace("/", "\/", $this->basePath) . '\//' => 'src="{$basePath}/',
			'/href="' . str_replace("/", "\/", $this->basePath) . '\//' => 'href="{$basePath}/',
			//'/(?:src="\{\$basePath\}\/([^"]*)"[ ]*)style="([ ]*(?:width:[ ]*(\d+)px;[ ]*)*(?:height:[ ]*(\d+)px;[ ]*)*(?:width:[ ]*(\d+)px;[ ]*)*)"/i' => 'src="{$basePath}/{=\'${1}\'|resize:${3}${5},${4}}" style="${2}" ',
		);
	}


}
