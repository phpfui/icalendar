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

use PHPUnit\Framework\Attributes\DataProvider;

class FileTest extends \PHPUnit\Framework\TestCase
	{
	/**
	 * Expressions data provider
	 *
	 * Test all files in examples directory
	 *
	 * @return array<array<string, string>>
	 */
	public static function providerICSFiles() : array
		{
		$iterator = new \DirectoryIterator(__DIR__ . '/examples');

		$contents = [];

		foreach ($iterator as $item)
			{
			if ($item->isFile())
				{
				$fileName = $item->getPathName();
				$contents[] = ['contents' => \file_get_contents($fileName), 'file' => $fileName];
				}
			}

		return $contents;
		}

	#[DataProvider('providerICSFiles')]
	public function testICSFiles(string $contents, string $file) : void
		{
		$this->assertNotEmpty($contents);
		$calendar = new \ICalendarOrg\ZCiCal($contents);
		$generated = $calendar->export();

		foreach (\explode("\n", $generated) as $line)
			{
			$this->assertLessThan(72, \strlen($line), "Line ->{$line}<- in file {$file} is too long (>72 chars)");
			}

		$resultsFile = __DIR__ . '/results/' . \basename($file);
		\file_put_contents($resultsFile, $generated);
		}
	}
