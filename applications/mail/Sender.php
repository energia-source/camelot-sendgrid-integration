<?PHP

namespace applications\mail;

use Entity\Map;
use Entity\Field;
use Entity\Validation;

class Sender extends Map
{
	protected function initialize() : void
	{
		$from = $this->addField('from');
		$from_pattern = Validation::factory('ShowString');
		$from->setPatterns($from_pattern);
		$from->addUniqueness(Field::PRIMARY);
		$from->setRequired();

		$sender = $this->addField('sender');
		$sender_pattern = Validation::factory('ShowString');
		$sender->setPatterns($sender_pattern);
		$sender->setRequired();

		$to = $this->addField('to');
		$to_pattern = Validation::factory('ShowString');
		$to->setPatterns($to_pattern);

		$reciver = $this->addField('reciver');
		$reciver_pattern = Validation::factory('ShowString');
		$reciver->setPatterns($reciver_pattern);
		$reciver->setRequired();

		$subject = $this->addField('subject');
		$subject_pattern = Validation::factory('ShowString');
		$subject->setPatterns($subject_pattern);

		$personalization = $this->addField('personalization');
		$personalization_pattern = Validation::factory('ShowObject');
		$personalization->setPatterns($personalization_pattern);
    }
}
