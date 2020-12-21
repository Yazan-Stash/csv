<?php

namespace YazanStash\Csv\Tests;

use YazanStash\Csv\Csv;
use PHPUnit\Framework\TestCase;

class CsvTest extends TestCase
{
    /** @test */
    public function the_random_file_name_is_40_character_long()
    {
        $this->assertEquals(40, strlen(str_replace('.csv', '', Csv::randomName())));
    }

    /** @test */
    public function not_passing_a_file_name_will_generate_a_random_one()
    {
        $this->assertStringStartsWith('/tmp/', Csv::create()->filePath());
        $this->assertStringEndsWith('.csv', Csv::create()->filePath());
    }

    /** @test */
    public function passing_a_file_name_will_use_it()
    {
        $this->assertEquals('/tmp/filename.csv', Csv::create('/tmp/filename.csv')->filePath());
    }

    /** @test */
    public function passing_an_invalid_path_will_throw_an_exception()
    {
        try {
            Csv::create('/root/tmp.csv');
        } catch (\Exception $e) {
            $this->assertStringContainsString('failed to open stream: Permission denied', $e->getMessage());

            return;
        }

        $this->fail('Expected an exception to be thrown, but did not.');
    }

    /** @test */
    public function can_write_array_to_file()
    {
        $file = Csv::create('/tmp/test-file.csv');

        $file->write(['Hello', 'Csv']);

        $this->assertEquals("Hello,Csv\n", file_get_contents('/tmp/test-file.csv'));
    }

    /** @test */
    public function filePath_returns_the_currently_opened_file_path()
    {
        $this->assertEquals('/tmp/random-file.csv', Csv::create('/tmp/random-file.csv')->filePath());
    }

    /** @test */
    public function calling_delimiter_without_aguments_returns_the_current_one()
    {
        $this->assertEquals(',', Csv::create()->delimiter());
    }

    /** @test */
    public function calling_delimiter_with_aguments_changes_it()
    {
        $this->assertEquals('|', Csv::create()->delimiter('|')->delimiter());
    }

    /** @test */
    public function calling_enclosure_without_aguments_returns_the_current_one()
    {
        $this->assertEquals('"', Csv::create()->enclosure());
    }

    /** @test */
    public function calling_enclosure_with_aguments_changes_it()
    {
        $this->assertEquals("'", Csv::create()->enclosure("'")->enclosure());
    }

    /** @test */
    public function calling_escapeCharacter_without_aguments_returns_the_current_one()
    {
        $this->assertEquals('\\', Csv::create()->escapeCharacter());
    }

    /** @test */
    public function calling_escapeCharacter_with_aguments_changes_it()
    {
        $this->assertEquals('|', Csv::create()->escapeCharacter('|')->escapeCharacter());
    }
}
