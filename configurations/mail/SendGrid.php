<?PHP

namespace configurations\mail;

use Knight\Lock;

final class SendGrid
{
	use Lock;

	const URL = ENVIRONMENT_SENDGRID_APIKEY_URL; 
	const KEY = ENVIRONMENT_SENDGRID_APIKEY;
	const AUTHORIZATION = [
		'Authorization: Bearer ' . SendGrid::KEY
	];
}
