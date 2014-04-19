=== Language Bar Flags ===
Contributors: meloniq
Donate link: http://blog.meloniq.net/donate/
Tags: bar, language, language bar, flags, europe, americas, asia, australia, africa, language selector
Requires at least: 3.5
Tested up to: 3.9
Stable tag: 1.0.6

Displays bar with configurable language flags to other language versions of Your website.

== Description ==

This plugin disable standard WordPress bar in the top of website, and display similar bar but with configurable language flags to other language versions of Your website (or display both bars). 

In administrative panel You see names of countries in English (or Your native language), but on Your website names of countries are displayed in thier native language.
Example: Germany (in backend), Deutschland (in frontend)

= Supported countries =
* Europe:
Albania, Austria, Belgium, Bulgaria, Belarus, Switzerland, Czech Republic, Germany, Denmark, Estonia, Spain, Finland, France, Greece, Croatia, Hungary, Ireland, Iceland, Italy, Liechtenstein, Lithuania, Luxembourg, Latvia, Montenegro, Malta, Netherlands, Norway, Poland, Portugal, Romania, Serbia, Russian Federation, Sweden, Slovenia, Slovakia, Turkey, Ukraine, United Kingdom
* America:
Argentina, Bahamas, Barbados, Belize, Bolivia, Brazil, Canada, Chile, Colombia, Costa Rica, Cuba, Dominica, Dominican Republic, Ecuador, El Salvador, Grenada, Guatemala, Guyana, Haiti, Honduras, Jamaica, Mexico, Nicaragua, Panama, Paraguay, Peru, Puerto Rico, Suriname, Trinidad and Tobago, United States, Uruguay, Venezuela
* Asia + Oceania:
Afghanistan, Armenia, Australia, Azerbaijan, Bahrain, Bangladesh, Bhutan, Brunei, Cambodia, China, Cyprus, Georgia, Hong Kong, India, Indonesia, Iran, Iraq, Israel, Japan, Jordan, Kazakhstan, Kuwait, Kyrgyzstan, Laos, Lebanon, Malaysia, Maldives, Mongolia, Myanmar, Nepal, New Zealand, North Korea, Oman, Pakistan, Papua New Guinea, Philippines, Qatar, Saudi Arabia, Singapore, South Korea, Sri Lanka, Syria, Taiwan, Tajikistan, Thailand, Timor-Leste, Turkmenistan, United Arab Emirates, Uzbekistan, Vietnam, Yemen
* Africa:
Algeria, Angola, Benin, Botswana, Burkina Faso, Burundi, Cameroon, Cape Verde, Central African Republic, Chad, Comoros, Republic of the Congo, Democratic Republic of the Congo, Côte d'Ivoire, Djibouti, Egypt, Equatorial Guinea, Eritrea, Ethiopia, Gabon, Gambia, Ghana, Guinea, Guinea-Bissau, Kenya, Lesotho, Liberia, Libya, Madagascar, Malawi, Mali, Mauritania, Mauritius, Morocco, Mozambique, Namibia, Niger, Nigeria, Rwanda, São Tomé and Príncipe, Senegal, Seychelles, Sierra Leone, Somalia, South Africa, Sudan, Swaziland, Tanzania, Togo, Tunisia, Uganda, Zambia, Zimbabwe

= Available languages =
* English
* French (by Frédéric Serva)
* Serbo-Croatian (by Borisa Djuraskovic from <a href="http://www.webhostinghub.com/">WebHostingHub</a>)
* Slovak (by Branco Radenovich from <a href="http://webhostinggeeks.com/user-reviews/">WebHostingGeeks</a>)
* Polish

If You translated plugin to Your native language, please send it to me, and will attach it to next release.
E-mail address You will find on <a href="http://blog.meloniq.net/kontakt/">contact page</a>.



== Installation ==

1. Upload the folder 'language-bar-flags' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to "Settings->Language Bar Flags" menu and fill settings.

== Changelog ==

= 1.0.6 =
* Added Serbo-Croatian translation
* Fixed display issues of bar on some themes
* Minor code styling corrections

= 1.0.5 =
* Added option to change position of bar, top or bottom of page
* Added option to change side of flags, left or right of bar
* Added option to set alternative country name
* Added Slovak translation
* Removed WP 2.8 compatibility constants
* Changed textdomain to 'language-bar-flags', represented by constant LANGBF_TD
* Added filter 'langbf_countries' on countries array
* Added filter 'langbf_tooltip' on tooltip args

= 1.0.4 =
* Added compatibility with WP Admin bar, can use both
* Added option to open links in new window
* Added Albania flag
* Fixed undefinied index notices
* Replaced CSS to separate function
* Replaced JS to separate function
* Updated French language (Thanks to Frédéric Serva)

= 1.0.3 =
* Added support for Africa

= 1.0.2 =
* Added support for Asia and Oceania
* Added French language (Thanks to Frédéric Serva)
* CSS tooltip fix (Thanks to Frédéric Serva)

= 1.0.1 =
* Added support for Americas
* Added optional title before flags
* Changed name of main plugin file and path in installation instruction because of difference between origin project name and this given by WordPress

= 1.0.0 =
* Initial release

== Upgrade Notice ==


== Frequently Asked Questions ==

= Why my country is not supported? =

Report it with details on <a href="http://wordpress.org/tags/language-bar-flags">support forum</a>.

= My country name is translated wrong, what to do? =

Report it with details on <a href="http://wordpress.org/tags/language-bar-flags">support forum</a>.

= Will this plugin translate my website? =

No, this plugin help to create cute links with flags to other versions of Your website.
For multilanguage content support, check plugins like qTranslate, mLanguage etc.


== Screenshots ==

1. Flag list in WordPress backend
2. View of bar in frontend

