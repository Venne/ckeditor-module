<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace CkeditorModule\DI;

use Nette\Config\CompilerExtension;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class CkeditorExtension extends CompilerExtension
{

	/**
	 * Processes configuration data. Intended to be overridden by descendant.
	 * @return void
	 */
	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$this->compiler->parseServices(
			$this->getContainerBuilder(),
			$this->loadFromFile(dirname(dirname(__DIR__)) . '/Resources/config/config.neon')
		);

		$ckeditorDir = $container->parameters['publicDir'] . '/ckeditor';


		if (!file_exists($ckeditorDir)) {
			mkdir($ckeditorDir, 0777, TRUE);
		}
		if (!file_exists($ckeditorDir . '/backend.json')) {
			copy($container->parameters['modules']['ckeditor']['path'] . '/Resources/backend.json', $ckeditorDir . '/backend.json');
		}
	}
}
