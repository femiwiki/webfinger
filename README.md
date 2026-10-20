# webfinger

Parse the `acct:` resources [WebFinger] is asked about on the fediverse and
build the JSON Resource Descriptor it answers with, in plain PHP.

The library does no I/O. Routing the request to
`/.well-known/webfinger` and looking up the account are left to the caller,
so it fits any framework.

```php
use Femiwiki\WebFinger\Account;
use Femiwiki\WebFinger\Jrd;

$account = Account::fromUri($_GET['resource']); // null unless acct:user@host
$document = Jrd::document($account->toUri(), [ $actorId ], [
    Jrd::link(Jrd::REL_SELF, $actorId, 'application/activity+json'),
    Jrd::link(Jrd::REL_PROFILE_PAGE, $pageUrl, 'text/html'),
]);
header('Content-Type: ' . Jrd::CONTENT_TYPE);
echo json_encode($document, JSON_UNESCAPED_SLASHES);
```

It was split out of [FediFeeds](https://github.com/femiwiki/FediFeeds), which
keeps its MediaWiki adapters.

Licensed under the [Apache License 2.0](LICENSE).

[WebFinger]: https://www.rfc-editor.org/rfc/rfc7033
