<?php

declare(strict_types=1);

namespace Femiwiki\WebFinger\Tests;

use Femiwiki\WebFinger\Jrd;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Jrd::class)]
class JrdTest extends TestCase
{
    public function testDocument(): void
    {
        $this->assertSame(
            [
                'subject' => 'acct:a@wiki.example.org',
                'aliases' => ['https://fedi.example.org/actors/a'],
                'links' => [
                    [
                        'rel' => 'self',
                        'type' => 'application/activity+json',
                        'href' => 'https://fedi.example.org/actors/a',
                    ],
                    [
                        'rel' => 'http://webfinger.net/rel/profile-page',
                        'href' => 'https://wiki.example.org/w/A',
                    ],
                ],
            ],
            Jrd::document(
                'acct:a@wiki.example.org',
                ['https://fedi.example.org/actors/a'],
                [
                    Jrd::link(Jrd::REL_SELF, 'https://fedi.example.org/actors/a', 'application/activity+json'),
                    Jrd::link(Jrd::REL_PROFILE_PAGE, 'https://wiki.example.org/w/A'),
                ],
            ),
        );
    }

    public function testDocumentLeavesOutWhatIsEmpty(): void
    {
        $this->assertSame(['subject' => 'acct:a@example.org'], Jrd::document('acct:a@example.org'));
    }
}
