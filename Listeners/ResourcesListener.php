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
use AssetsModule\Managers\AssetManager;
use CmsModule\Events\RenderEvents;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class ResourcesListener implements EventSubscriber
{

	/** @var AssetManager */
	protected $assetManager;


	/**
	 * @param AssetManager $assetManager
	 */
	public function __construct(AssetManager $assetManager)
	{
		$this->assetManager = $assetManager;
	}


	/**
	 * Array of events.
	 *
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return array(RenderEvents::onHeadBegin);
	}


	public function onHeadBegin(\CmsModule\Events\RenderArgs $args)
	{
		if ($args->getPresenter() instanceof \CmsModule\Presenters\AdminPresenter) {
			$this->assetManager->addJavascript('@CkeditorModule/ckeditor/ckeditor.js');
			$this->assetManager->addJavascript('@CkeditorModule/editor.js');
		}
	}
}
