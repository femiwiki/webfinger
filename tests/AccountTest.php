<?php

declare(strict_types=1);

namespace Femiwiki\WebFinger\Tests;

use Femiwiki\WebFinger\Account;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Account::class)]
class AccountTest extends TestCase
{
    /**
     * @return iterable<string, array{string, ?string, ?string}>
     */
    public static function provideFromUri(): iterable
    {
        yield 'plain' => ['acct:category_1@wiki.example.org', 'category_1', 'wiki.example.org'];
        yield 'host lower-cased' => ['acct:a@Wiki.Example.ORG', 'a', 'wiki.example.org'];
        yield 'user keeps its case' => ['acct:Alice@example.org', 'Alice', 'example.org'];
        yield 'last @ splits' => ['acct:a@b@example.org', 'a@b', 'example.org'];
        yield 'an actor id' => ['https://fedi.example.org/actors/a', null, null];
        yield 'no host' => ['acct:a', null, null];
        yield 'empty user' => ['acct:@example.org', null, null];
        yield 'empty host' => ['acct:a@', null, null];
    }

    #[DataProvider('provideFromUri')]
    public function testFromUri(string $uri, ?string $user, ?string $host): void
    {
        $account = Account::fromUri($uri);
        $this->assertSame($user, $account?->user);
        $this->assertSame($host, $account?->host);
    }

    public function testToUri(): void
    {
        $this->assertSame('acct:a@example.org', (new Account('a', 'example.org'))->toUri());
    }
}
