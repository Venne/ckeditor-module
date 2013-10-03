<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace CkeditorModule\Presenters;

use CkeditorModule\Forms\CkeditorFormFactory;
use CmsModule\Administration\Presenters\BasePresenter;
use Venne\Forms\Form;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 *
 * @secured
 */
class CkeditorPresenter extends BasePresenter
{

	/** @var CkeditorFormFactory */
	protected $ckeditorFormFactory;


	/**
	 * @param CkeditorFormFactory $ckeditorFormFactory
	 */
	public function injectCkeditorFormFactory(CkeditorFormFactory $ckeditorFormFactory)
	{
		$this->ckeditorFormFactory = $ckeditorFormFactory;
	}


	/**
	 * @secured(privilege="show")
	 */
	public function actionDefault()
	{
	}


	protected function createComponentForm()
	{
		$form = $this->ckeditorFormFactory->invoke();
		$form->onSuccess[] = $this->formSuccess;
		return $form;
	}


	public function formSuccess(Form $form)
	{
		if ($form->isSubmitted() !== $form->getSaveButton()) {
			return;
		}

		$this->flashMessage($this->translator->translate('Configuration has been saved.'), 'success');

		if (!$this->isAjax()) {
			$this->redirect('this');
		}
	}
}
