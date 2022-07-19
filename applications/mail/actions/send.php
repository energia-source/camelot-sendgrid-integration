<?php

namespace applications\mail\actions;

use configurations\mail\SendGrid as Configuration;

use SendGrid;
use SendGrid\Mail\Mail;

use Knight\armor\Output;
use Knight\armor\Request;
use Knight\armor\Navigator;
use Knight\armor\Language;

use applications\mail\Sender;

$template = parse_url($_SERVER[Navigator::REQUEST_URI], PHP_URL_PATH);
$template = basename($template);

$sender = new Sender();
$sender->setFromAssociative((array)Request::post());

if (!!$errors = $sender->checkRequired()->getAllFieldsWarning()) {
	Language::dictionary(__file__);
	$notice = __namespace__ . '\\' . 'notice';
	$notice = Language::translate($notice);
	Output::concatenate('notice', $notice);
	Output::concatenate('errors', $errors);
	Output::print(false);
}

$personalization = (array)$sender->getField('personalization')->getValue();
$personalization[$sender->getField('subject')->getName()] = $sender->getField('subject')->getValue();

$email = new Mail();
$email->enableBypassListManagement();
$email->setFrom(
	$sender->getField('from')->getValue(),
	$sender->getField('sender')->getValue()
);
$email->setTemplateId($template);
$email->addTo(
	$sender->getField('to')->getValue(),
	$sender->getField('reciver')->getValue(),
	$personalization,
	0
);

try {
    $sendgrid = new SendGrid(Configuration::KEY);
    $response = $sendgrid->send($email);
    if (202 === $response->statusCode()) Output::print(true);
} catch (Exception $exception) {
    Output::concatenate('errors', $exception->getMessage());
	Output::print(false);
}

Output::print(false);
