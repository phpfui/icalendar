<?php

class SyntaxTest extends \PHPFUI\PHPUnitSyntaxCoverage\Extensions
	{
	public function testDirectory() : void
		{
		$this->addSkipDirectory('makefont');
		$this->assertValidPHPDirectory(__DIR__ . '/../src', 'src directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../tests', 'tests directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../examples', 'examples directory has an error');
		}

	public function testValidPHPFile() : void
		{
		$this->assertValidPHPFile(__DIR__ . '/../.php-cs-fixer.dist.php', '.php-cs-fixer.dist.php file is bad');
		}
	}
