<?php

declare(strict_types=1);

namespace Femiwiki\WebFinger;

/**
 * The JSON Resource Descriptor a WebFinger server answers with (RFC 7033 section 4.4)
 */
class Jrd
{
    public const CONTENT_TYPE = 'application/jrd+json';
    public const REL_SELF = 'self';
    public const REL_PROFILE_PAGE = 'http://webfinger.net/rel/profile-page';

    /**
     * @param string $subject
     * @param string[] $aliases
     * @param array<string, string>[] $links Each from link()
     * @return array{subject: string, aliases?: list<string>, links?: list<array<string, string>>} Ready for json_encode()
     */
    public static function document(string $subject, array $aliases = [], array $links = []): array
    {
        $document = ['subject' => $subject];
        if ($aliases) {
            $document['aliases'] = array_values($aliases);
        }
        if ($links) {
            $document['links'] = array_values($links);
        }
        return $document;
    }

    /**
     * @param string $rel
     * @param string $href
     * @param string|null $type The media type of what href points to
     * @return array<string, string>
     */
    public static function link(string $rel, string $href, ?string $type = null): array
    {
        $link = ['rel' => $rel];
        if ($type !== null) {
            $link['type'] = $type;
        }
        $link['href'] = $href;
        return $link;
    }
}
