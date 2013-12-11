Fluid Content: Core Elements
============================

> A replacement for `EXT:css_styled_content` 100% powered by Fluid and Flux Forms.

## What does it do?

Just like `EXT:css_styled_content` this extension adds rendering instructions for records from tt_content. But rather than use
TypoScript to manipulate rendering, each content element type is assigned one Fluid template and is _entirely rendered in Fluid_.

## Does it actually work? There's no code!?

Sure, buddy. Go ahead and try it out! At the time of writing this, though, most of the content templates are "Hello world".
That'll change though - a sane, very basic set of default templates is intended.

## Why use it?

It does not get any more flexible than this when it comes to custom styled TYPO3 CMS sites. You can replace any number of built-in
content elements with your own Fluid templates. You can switch which templates get used on individual subpages (using TypoScript
to override view paths). You can use template path overlays like you know from `EXT:view`. Instead of using either a FlexForm or
adding TCA/DB columns, you can simply insert a Flux form definition in the template file and add any number of fields you wish to
use to control rendering.

You can even throw any number of these built-in content element types into a Flux Provider extension and add (static) TypoScript
setup to make this extension use your template paths first, with fallback to the included templates. Note, though, that you
should not mix these core content element tempaltes with your own custom elements for `EXT:fluidcontent`.

## Examples

Built-in template files are under `Resources/Private/Templates/Content` - they all share one Layout file and use one Partial
template to render a shared header (equivalent of `lib.stdHeader` in `EXT:css_styled_content`). The individual plugins get
configured in `ext_localconf.php` (one plugin per content type, matching each possible `CType` value) and a tiny little bit of
TypoScript is used to build a very basic `tt_content.*` array which is required in order to render anything. This, along with the
template path definitions you already know - and any custom settings you choose to add and thereby make available in templates -
is the only TypoScript needed by this extension. The view definitions are exactly like you know from any Extbase plugin.

In essence, this is an Extbase plugin to replace the TypoScript based rendering of `EXT:css_styled_content` and leveraging Flux
to make it extremely easy to configure exactly the right fields you want to use to configure your contents' appearance.

This is very likely to be one of the simplest extensions you have ever used and everything builds on conventions from both Flux,
Extbase and Fluid to give you the ultimate degree of flexibility.

## Built-in content element types

* Header.html
* Text.html
* Image.html
* Textpic.html
* Bullets.html
* Uploads.html
* Table.html
* Media.html
* Mailform.html
* Search.html
* Menu.html
* Shortcut.html
* Div.html
* Html.html (yeah, you read it...)
* Default.html

## Plans for future improvements

1. Finish the basic set of included templates to make a fallback-quality rendering
2. Implement any shared fields every content element should use
3. Introduce an asset configuration integration (possibly leveraging LESS/SASS to grab Flux Form values to use in compiled CSS)
4. Consider additional integration options, for example registering multiple variations of built-in content elements and letting
   content editors choose between them, much like page templates.
5. Try to take over the world. Same as every other night, Pinky.
