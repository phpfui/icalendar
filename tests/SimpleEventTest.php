<?php

/**
 * This file is part of the ICalendarOrg package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source
 * code
 */
class SimpleEventTest extends \PHPUnit\Framework\TestCase
	{
	public function testAddInvalidNode() : void
		{
		$this->expectException(\UnexpectedValueException::class);
		$icalobj = new \ICalendarOrg\ZCiCal();

		$icalobj->addDataNode(new \ICalendarOrg\ZCiCalDataNode('NAME:My Calendar Name'), new \ICalendarOrg\ZCiCalDataNode('FRED:Flintstone'));
		}

	public function testSimpleEvent() : void
		{
		$title = 'Simple Event';
		// date/time is in SQL datetime format
		$event_start = '2020-01-01 12:00:00';
		$event_end = '2020-01-01 13:00:00';

		// create the ical object
		$icalobj = new \ICalendarOrg\ZCiCal();

		// add name
		$icalobj->addDataNode(new \ICalendarOrg\ZCiCalDataNode('NAME:My Calendar Name'), new \ICalendarOrg\ZCiCalDataNode('PRODID:-//ZContent.net//ZapCalLib 1.0//EN'));

		// create the event within the ical object
		$eventobj = new \ICalendarOrg\ZCiCalNode('VEVENT', $icalobj->curnode);

		$eventobj->addNode(new \ICalendarOrg\ZCiCalDataNode('SUMMARY:' . $title));

		// add start date
		$eventobj->addNode(new \ICalendarOrg\ZCiCalDataNode('DTSTART:' . \ICalendarOrg\ZDateHelper::fromSqlDateTime($event_start)));

		// add end date
		$eventobj->addNode(new \ICalendarOrg\ZCiCalDataNode('DTEND:' . \ICalendarOrg\ZDateHelper::fromSqlDateTime($event_end)));

		// UID is a required item in VEVENT, create unique string for this event
		// Adding your domain to the end is a good way of creating uniqueness
		$uid = \date('Y-m-d-H-i-s') . '@demo.icalendar.org';
		$eventobj->addNode(new \ICalendarOrg\ZCiCalDataNode('UID:' . $uid));

		// DTSTAMP is a required item in VEVENT
		$eventobj->addNode(new \ICalendarOrg\ZCiCalDataNode('DTSTAMP:' . \ICalendarOrg\ZDateHelper::fromSqlDateTime()));

		// Add description
		$eventobj->addNode(new \ICalendarOrg\ZCiCalDataNode('Description: This is a simple event, using the Zap Calendar PHP library. Visit http://icalendar.org to validate icalendar files.'));

		$icalString = $icalobj->export();
		$this->assertStringContainsString('My Calendar Name', $icalString);
		}
	}
