<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Console\Commands\MigrateLegacyData;
use ReflectionProperty;

class MigrateLegacyDataTest extends TestCase
{
    private function makeCommand(string $sqlContent): array
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'sql');
        file_put_contents($tempFile, $sqlContent);

        $command = new MigrateLegacyData();

        $prop = new ReflectionProperty(MigrateLegacyData::class, 'sqlPath');
        $prop->setAccessible(true);
        $prop->setValue($command, $tempFile);

        return [$command, $tempFile];
    }

    public function test_parse_handles_multiple_statements(): void
    {
        $sql = <<<SQL
INSERT INTO `users` (`id`, `name`, `email`) VALUES
(1, 'John Doe', 'john@example.com'),
(2, 'Jane Doe', 'jane@example.com');

INSERT INTO `users` (`id`, `name`, `email`) VALUES
(3, 'Bob Smith', 'bob@example.com');
SQL;

        [$command, $tempFile] = $this->makeCommand($sql);
        $results = $command->parse('users');
        unlink($tempFile);

        $this->assertCount(3, $results);
        $this->assertEquals('John Doe', $results[0]['name']);
        $this->assertEquals('Jane Doe', $results[1]['name']);
        $this->assertEquals('Bob Smith', $results[2]['name']);
    }

    public function test_parse_handles_null_values(): void
    {
        $sql = "INSERT INTO `users` (`id`, `name`, `email`) VALUES (1, 'John Doe', NULL);";

        [$command, $tempFile] = $this->makeCommand($sql);
        $results = $command->parse('users');
        unlink($tempFile);

        $this->assertCount(1, $results);
        // parse() returns string 'NULL'; entity mappers convert it via nullable() helper
        $this->assertEquals('NULL', $results[0]['email']);
    }
}
