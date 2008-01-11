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
Drop it into your modules folder and turn it on. Obviously, it requires the Views module to
do its magic.

If you want to display the filter tips (i.e. instructions on how to add insert view
tags) in the formatting options of your node add/edit pages, go to Administer > Input
formats > configure for the input format to which you want to add the "filter".  This step
isn't required to make the module work, please note.  The module works as soon as it is
enabled, so keep that in mind for security purposes.

Insert_view is not a strict filter module  It uses some filter hooks to provide formatting
instructions via the filter system, but actually accomplishes its inserting of views through
hook_nodeapi() so that it has the proper context within which to run.  Because there is no
hook_nodeapi() equivalent for blocks (that this developer is aware of), we can't similarly
parse blocks.  If you've enabled the filter tips (as detailed in the previous paragraph), you
the insert_view filter tips will appear on your block edit page but they won't work.  This is
an unfortunate result of using filter tips to display this info, as normally filter tips
would work for blocks.  In this case, however, they don't, and I'm yet to identify an elegant
solution to the issue.

To Do
-----
- Add permissions handling.
- Filter tips appearing on block edit pages despite hook_nodeapi() not running for blocks.