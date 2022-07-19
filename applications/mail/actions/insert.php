<?php

namespace applications\mail\actions;

use stdClass;
use configurations\mail\SendGrid as Configuration;

use SendGrid\Client;

use Knight\armor\Output;
use Knight\armor\Request;
use Knight\armor\Language;
use Knight\armor\Navigator;

use applications\mail\Recipient;

$lists = parse_url($_SERVER[Navigator::REQUEST_URI], PHP_URL_PATH);
$lists = explode(chr(47), $lists);
$lists = array_slice($lists, Navigator::getDepth() + 2);

$contact = new Recipient();
$contact->setFromAssociative((array)Request::post());

if (!!$errors = $contact->checkRequired()->getAllFieldsWarning()) {
	Language::dictionary(__file__);
	$notice = __namespace__ . '\\' . 'notice';
	$notice = Language::translate($notice);
	Output::concatenate('notice', $notice);
	Output::concatenate('errors', $errors);
	Output::print(false);
}

$sendgrid = new Client(Configuration::URL, Configuration::AUTHORIZATION);
$sendgrid_request = new stdClass();
$sendgrid_request->list_ids = &$lists;
$sendgrid_request->contacts = [
	$contact->getAllFieldsValues(false, false)
];

try {
    $response = $sendgrid->marketing()->contacts()->put($sendgrid_request);
	if (202 === $response->statusCode()) Output::print(true);
} catch (Exception $exception) {
	Output::concatenate('errors', $exception->getMessage());
	Output::print(false);
}

Output::print(false);
