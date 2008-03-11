OVERVIEW
--------
Merlinofchaos' excellent Views module allows site admins to build dynamic content lists
for display on pages and in blocks. It also offers a few handy functions for imbedding
view lists in other node bodies. Doing that, though, requires PHP filtering rights for
whoever maintains the node. View Tags allows users to embed these lists in node bodies
using relatively simple tag syntax:

[view:<name of view>] is replaced by the content listing, and

[view:<name of view>=<number>] limits the listing to a particular <number> of entries.

[view:<name of view>=<number>=<comma-delimited-list>] limits the listing to a
particular <number> of entries, and passes a comma delimited list of arguments to the view.

Here's an example you could use with a view named "book_reviews" that takes a taxonomy
term ID as an argument:

[view:book_reviews=5=2]

In short this tag says, "Insert the view named book_reviews, limit the number of results to
5, and supply the argument/term ID 2."

INSTALLATION
------------
Extract and save the Insert View folder in your site's modules folder and enable it at
admin/build/modules. Obviously, it requires the Views module to do its magic.

Once Insert View is installed, visit the the input formats page at /admin/settings/filters
and click the "configure" link for the input format(s) for which you wish to enable the
Insert View Filter.  Then simply check the checkbox for the filter.

UPGRADING FROM A PREVIOUS VERSION?
----------------------------------
In previous versions of Insert View (including the 2008-Jan-11 development snapshot
and earlier) it was was not required to enable the Insert View filter for input formats
(by visiting the /admin/settings/filters pages) because Insert View was a pseudo filter
and used hook_nodeapi() rather than the filter system.

Insert View now runs as a classic Drupal filter module, and that means it now works
in blocks.  If you upgrade your site and find Insert View tags aren't working, please
visit /admin/settings/filters and enable the Insert View Filter for each input format
necessary.