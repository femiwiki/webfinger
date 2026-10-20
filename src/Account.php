<?php

declare(strict_types=1);

namespace Femiwiki\WebFinger;

/**
 * An acct: URI (RFC 7565), as WebFinger is asked about on the fediverse: acct:user@host
 */
class Account
{
    public function __construct(
        public readonly string $user,
        public readonly string $host,
    ) {}

    /**
     * @param string $uri Such as acct:alice@example.org
     * @return self|null Null for anything else, an empty user or an empty host
     */
    public static function fromUri(string $uri): ?self
    {
        if (!str_starts_with($uri, 'acct:')) {
            return null;
        }
        $at = strrpos($uri, needle: '@');
        if ($at === false) {
            return null;
        }
        $user = substr($uri, strlen('acct:'), $at - strlen('acct:'));
        $host = strtolower(substr($uri, $at + 1));
        if ($user === '' || $host === '') {
            return null;
        }
        return new self($user, $host);
    }

    public function toUri(): string
    {
        return "acct:{$this->user}@{$this->host}";
    }
}
