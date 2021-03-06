<?php

/**
 * @file classes/submission/form/SubmissionSubmitStep1Form.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubmissionSubmitStep1Form
 * @ingroup submission_form
 *
 * @brief Form for Step 1 of author submission.
 */

import('lib.pkp.classes.submission.form.PKPSubmissionSubmitStep1Form');

class SubmissionSubmitStep1Form extends PKPSubmissionSubmitStep1Form {
	/**
	 * Constructor.
	 */
	function SubmissionSubmitStep1Form($context, $submission = null) {
		parent::PKPSubmissionSubmitStep1Form($context, $submission);
	}

	/**
	 * Fetch the form.
	 */
	function fetch($request) {
		$templateMgr = TemplateManager::getManager($request);

		// Get series for this context
		$seriesDao = DAORegistry::getDAO('SeriesDAO');
		$seriesOptions = array('0' => __('submission.submit.selectSeries')) + $seriesDao->getTitlesByPressId($this->context->getId());
		$templateMgr->assign('seriesOptions', $seriesOptions);

		return parent::fetch($request);
	}

	/**
	 * Initialize form data from current submission.
	 */
	function initData() {
		if (isset($this->submission)) {
			parent::initData(array(
				'seriesId' => $this->submission->getSeriesId(),
				'seriesPosition' => $this->submission->getSeriesPosition(),
				'workType' => $this->submission->getWorkType(),
			));
		} else {
			parent::initData();
		}
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array(
			'workType', 'seriesId', 'seriesPosition',
		));
		parent::readInputData();
	}

	/**
	 * Set the submission data from the form.
	 * @param $submission Submission
	 */
	function setSubmissionData($submission) {
		$submission->setWorkType($this->getData('workType'));
		$submission->setSeriesId($this->getData('seriesId'));
		$submission->setSeriesPosition($this->getData('seriesPosition'));
		parent::setSubmissionData($submission);
	}
}

?>
