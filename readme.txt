=== Language Bar Flags ===
Contributors: meloniq
Donate link: https://blog.meloniq.net/donate/
Tags: bar, language, language bar, flags, europe, americas, asia, australia, africa, language selector
Requires at least: 4.9
Tested up to: 5.7.2
Stable tag: 1.1.1

Displays bar with configurable language flags to other language versions of Your website.

== Description ==

This plugin disable standard WordPress bar in the top of website, and display similar bar but with configurable language flags to other language versions of your website (or display both bars). 

In administrative panel you see names of countries in English (or your native language), but on your website names of countries are displayed in thier native language.
Example: Germany (in backend), Deutschland (in frontend)

= Supported countries =
* Europe:
Albania, Andorra, Austria, Belgium, Belarus, Bosnia and Herzegovina, Bulgaria, Croatia, Czech Republic, Denmark, Estonia, Faroe Islands, Finland, France, Germany, Gibraltar, Greece, Guernsey, Hungary, Iceland, Ireland, Isle of Man, Italy, Jersey, Kosovo, Latvia, Liechtenstein, Lithuania, Luxembourg, Macedonia, Malta, Moldova, Monaco, Montenegro, Netherlands, Northern Cyprus, Norway, Poland, Portugal, Romania, Russian Federation, San Marino, Serbia, Slovenia, Slovakia, Spain, Sweden, Switzerland, Turkey, Ukraine, United Kingdom, Vatican

* America:
Anguilla, Antigua and Barbuda, Argentina, Aruba, Bahamas, Barbados, Belize, Bermuda, Bolivia, Brazil, British Virgin Islands, Canada, Cayman Islands, Chile, Colombia, Costa Rica, Cuba, Dominica, Dominican Republic, Ecuador, El Salvador, Greenland, Grenada, Guatemala, Guyana, Haiti, Honduras, Jamaica, Mexico, Montserrat, Nicaragua, Panama, Paraguay, Peru, Puerto Rico, Saint Kitts and Nevis, Saint Lucia, Saint Vincent and the Grenadines, Suriname, Trinidad and Tobago, Turks and Caicos Islands, United States, United States Virgin Islands, Uruguay, Venezuela

* Asia + Oceania:
Afghanistan, American Samoa, Armenia, Australia, Azerbaijan, Bahrain, Bangladesh, Bhutan, Brunei, Cambodia, China, Cook Islands, Cyprus, Easter Island, Federated States of Micronesia, Fiji, French Polynesia, Georgia, Guam, Hong Kong, India, Indonesia, Iran, Iraq, Israel, Japan, Jordan, Kazakhstan, Kiribati, Kuwait, Kyrgyzstan, Laos, Lebanon, Macau, Malaysia, Maldives, Marshall Islands, Mongolia, Myanmar, Nauru, Nepal, New Caledonia, New Zealand, North Korea, Oman, Pakistan, Palau, Palestine, Papua New Guinea, Philippines, Qatar, Samoa, Saudi Arabia, Singapore, Solomon Islands, South Korea, Sri Lanka, Syria, Taiwan, Tajikistan, Thailand, Timor-Leste, Tonga, Turkmenistan, Tuvalu, United Arab Emirates, Uzbekistan, Vanuatu, Vietnam, Yemen

* Africa:
Algeria, Angola, Benin, Botswana, Burkina Faso, Burundi, Cameroon, Cape Verde, Central African Republic, Chad, Comoros, Republic of the Congo, Democratic Republic of the Congo, Côte d'Ivoire, Djibouti, Egypt, Equatorial Guinea, Eritrea, Ethiopia, Gabon, Gambia, Ghana, Guinea, Guinea-Bissau, Kenya, Lesotho, Liberia, Libya, Madagascar, Malawi, Mali, Mauritania, Mauritius, Morocco, Mozambique, Namibia, Niger, Nigeria, Réunion, Rwanda, Sahrawi Arab Democratic Republic, São Tomé and Príncipe, Senegal, Seychelles, Sierra Leone, Somalia, South Africa, Sudan, Swaziland, Tanzania, Togo, Tunisia, Uganda, Zambia, Zimbabwe


== Installation ==

1. Upload the folder 'language-bar-flags' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to "Settings->Language Bar Flags" menu and fill settings.

== Changelog ==

= 1.1.1 =
* Updated Bootstrap lib from 4.5 to 5.0
* Validate & escape entered by admin url

= 1.1.0 =
* Added WP CLI support
* Fixed tooltips on flags
* Fixed XSS issue

= 1.0.9 =
* Added Belarusian translation

= 1.0.8 =
* Added 47 new flags/countries

= 1.0.7 =
* Added Ukrainian translation

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

Report it with details on [support forum](https://wordpress.org/support/plugin/language-bar-flags/).

= My country name is translated wrong, what to do? =

Report it with details on [support forum](https://wordpress.org/support/plugin/language-bar-flags/).

= Will this plugin translate my website? =

No, this plugin help to create cute links with flags to other versions of Your website.
For multilanguage content support, check plugins like qTranslate, mLanguage etc.

= How can I contribute? =

Fork repo from [GitHub](https://github.com/meloniq/language-bar-flags) and open PR.


== Screenshots ==

1. Flag list in WordPress backend
2. View of bar in frontend

