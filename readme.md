# [ezIPTV v0.3](https://github.com/spencerthayer/ezIPTV)

ezIPTV is a simple and free personal IPTV manager.

Services like [Xtream Editor](https://xtream-editor.com) and [IPTV EPG](https://www.iptv-epg.com/) are clunky, expensive, and for the most part suck. Editing large IPTV lists on these services is so annoying and slow making that it makes the fact that it costs money feel like a rip off. While these services do offer a convenient and reliable solution for EPG a smart IPTV user should be able to find EPG data for free.

ezIPTV was created to be a DIY solution for IPTV enthusiasts. Instead of managing your M3U on a clunky website's database ezIPTV converts M3U files into CSV so that they can be manipulated easily with any spreadsheet software such as [Google Sheets](https://www.google.com/sheets/about/), [Microsoft Excel](https://products.office.com/en-us/excel), [Libre Office Calc](https://www.libreoffice.org/discover/calc), and [Apache Calc](https://www.openoffice.org/product/calc.html).

Oh, also it's all free. ezIPTV was created with the intention of using the free Heroku self hosted services. **And if you came here from [Reddit](https://www.reddit.com/r/IPTV/comments/bi7l5j/100_free_selfhosted_iptv_management/) thanks!**

## How to install on Heroku
[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy?template=https://github.com/spencerthayer/ezIPTV)

With Heroku anyone can build their own ezIPTV for free in just a few minutes!
- [Create a free account with Heroku](https://signup.heroku.com/php) if you haven't done so already.
- Just click the [`Deploy to Heroku`](https://heroku.com/deploy?template=https://github.com/spencerthayer/ezIPTV).
- Fill out the Heroku form and click build.
- Open your new app URL and do the simple setup.

_THAT'S IT!_

## How to install on a server
**Note: ezIPTV cannot be run within a domain subdirectory as of right now!**

Even on hosted servers ezIPTV installation is extremely easy.
- Either clone the repository `git clone https://github.com/spencerthayer/ezIPTV ezIPTV` or [download the zip](https://github.com/spencerthayer/ezIPTV/archive/master.zip).
- Clone or extract ezIPTV into the root directory of your site.
- Ensure ezIPTV has read/write permissions for all directories.
- Open your new app and follow the instructions.
- Ensure that the setup correctly created the `.htaccess` mod rewrite capabilities.

_THAT'S IT!_

## How to use

Using ezIPTV isn't actually super easy, but it's not hard once you figure it out.

### Format your M3U

- Create a new link and copy and paste the links to the IPTV services into the field for the M3U links to be converted into a CSV file. You combine multiple M3Us.
- Save your new link.
- Click the `CSV` button to download the CSV file.
- Now import that CSV file into your favorite Spreadsheet software.

To see an example CSV file [download this sample](https://docs.google.com/spreadsheets/d/e/2PACX-1vRCK3VaABs6SlEL-nBXtbvDPhMkgbKpHKENGK_-1kOtkpUT2KSznjlTgCbmT2lcur9LinZRM7c-wDp-/pub?gid=878215409&single=true&output=csv).

### Format your CSV file

ezIPTV converts M3U using the following table convention names.

`ACTIVE, ERROR, REGION, CODE, CATEGORY, GROUP, TAG, ID, NAME, EPGID,LOGOURL, URL, EPGURL, PROVIDER, NOTES`

- `ACTIVE`: If the field is _YES_ the channel will show in the M3U. Anything other than _YES_ will not be published.
- `ERROR`: If a channel has an error put the error code for the channel in this field. (This doesn't do anything at the moment but will in a later version.)
- `REGION`: This is the region for the channel, typically it looks like _USA_ or _CANADA_.
- `CODE`: This is the country code for the channel,typically it looks like _US_ or _CA_.
- `CATEGORY`: This is the category for the channel, this is something like _LOCAL_ or _KIDS_.
- `GROUP`: This is used to supersede `REGION` and `CATEGORY` to group channels together, this can be something like NEWS.
- `TAG`: This is a special note used to organize channels in regions, categories, and groups. This can most likely be used to make favorites with a special character like `★`.
- `ID`: This is the original ID of the channel from the M3U file unaltered. *This should be left alone.*
- `NAME`: This can be used to change the names of channels.
- `EPGID`: This is the EPG or TVG code ID for the channel. Use this to make sure you're getting accurate EPG data from your EPG XML.
- `LOGOURL`: This is the URL to the channel logo.
- `URL`: This is the streaming URL for the channel. *This should be left alone.*
- `PROVIDER`: This an extra field to help organize the provider of the channel. (This doesn't do anything at the moment but will in a later version.)
- `NOTES`: This is an extra field used for notes. It's good to keep notes and stay organized.

### Publish your CSV file

As of this version ezIPTV does not allow you to upload a CSV file. Until this changes it is recommend publishing the CSV file to the web using [Google Sheets to CSV](https://support.google.com/docs/answer/183965).

### Getting your new M3U file

- Publish the Google Sheets CSV URL into the field for link to the CSV used to generate the M3U.
- Save your link.
- Click the `M3U` button to get a link to your new M3U file.
- Now import that CSV file into your favorite Spreadsheet software.

## ToDo
If you can help me work out these issues or donate to support my development I would appreciate it.
- [ ] Allow application to run within a domain subdirectory.
- [ ] CSV and M3U file management (Upload / Delete).
- [ ] Backup site data (Import / Export). 
- [ ] One click code upgrades.
- [ ] M3U list filtering.
- [ ] EPG XML combination and compression.
- [ ] YouTube URL to RSS conversion.
  - [ ] [Better XMLTV formatting.](https://www.xmltvlistings.com/help/api/xmltv)
  - [ ] [Grab Youtube XML](https://commentpicker.com/youtube-channel-id.php) and extract the MP4.
 

## Dependencies
In a later version this list of dependencies will auto-magically download to remain up to date. Right now, don't worry about it. It works.

- [MD Bootstrap](https://mdbootstrap.com)
- [JSON Database](https://github.com/plamendev/json-database)
- [Link Router](https://github.com/apsdehal/Link)
- [PHP XML Merge](https://github.com/hareko/php-merge-xml)