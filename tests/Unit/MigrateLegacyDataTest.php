<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Console\Commands\MigrateLegacyData;
use ReflectionMethod;

class MigrateLegacyDataTest extends TestCase
{
    public function test_parse_insert_statements_handles_multiple_statements()
    {
        $sql = <<<SQL
INSERT INTO `users` (`id`, `name`, `email`) VALUES
(1, 'John Doe', 'john@example.com'),
(2, 'Jane Doe', 'jane@example.com');

INSERT INTO `users` (`id`, `name`, `email`) VALUES
(3, 'Bob Smith', 'bob@example.com');
SQL;

        $tempFile = tempnam(sys_get_temp_dir(), 'sql');
        file_put_contents($tempFile, $sql);

        $command = new MigrateLegacyData();
        $method = new ReflectionMethod(MigrateLegacyData::class, 'parseInsertStatements');

        $results = $method->invoke($command, $tempFile, 'users');

        unlink($tempFile);

        $this->assertCount(3, $results);
        $this->assertEquals('John Doe', $results[0]['name']);
        $this->assertEquals('Jane Doe', $results[1]['name']);
        $this->assertEquals('Bob Smith', $results[2]['name']);
    }

    public function test_parse_insert_statements_handles_null_values()
    {
        $sql = "INSERT INTO `users` (`id`, `name`, `email`) VALUES (1, 'John Doe', NULL);";

        $tempFile = tempnam(sys_get_temp_dir(), 'sql');
        file_put_contents($tempFile, $sql);

        $command = new MigrateLegacyData();
        $method = new ReflectionMethod(MigrateLegacyData::class, 'parseInsertStatements');

        $results = $method->invoke($command, $tempFile, 'users');

        unlink($tempFile);

        $this->assertCount(1, $results);
        $this->assertNull($results[0]['email']);
    }
}
