<?PHP

namespace applications\mail;

use Entity\Map;
use Entity\Field;
use Entity\Validation;

class Recipient extends Map
{
	protected function initialize() : void
	{
		$email = $this->addField('email');
		$email_pattern = Validation::factory('Email');
		$email->setPatterns($email_pattern);
		$email->addUniqueness(Field::PRIMARY);
		$email->setRequired();  

		$first_name = $this->addField('first_name');
		$first_name_pattern = Validation::factory('ShowString');
		$first_name->setPatterns($first_name_pattern);

		$last_name = $this->addField('last_name');
		$last_name_pattern = Validation::factory('ShowString');
		$last_name->setPatterns($last_name_pattern);  

		$country = $this->addField('country');
		$country_pattern = Validation::factory('ShowString', 'en');
		$country_pattern->setMin(2)->setMax(3);
		$country->setPatterns($country_pattern);
    }
}
