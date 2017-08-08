# se-ranking-api-wrapper

API Wrapper for the SE Ranking API

SE Ranking API documentation: [Link](https://seranking.com/api.html "Link")

# Install

Add the following repositiory to your composer.json file

```
"repositories": [
{
      "type": "vcs",
      "url": "https://github.com/aidanbigg/se-ranking-api-wrapper.git"
  }
],
```

Require the package

```
"bigg/se-ranking-api-wrapper": "dev-master"
```

Install the package

```
composer update "bigg/se-ranking-api-wrapper"
```

You may need to run the following command if any classes are not found:

```
composer dump-autoload -o
```

# Usage

Set the username & password for the API in the applications environment

```
putenv( 'SE_RANKING_USERNAME=username' );
putenv( 'SE_RANKING_PASSWORD=password' );
```

## Create Site (this will automatically add the search engines - Google, Bing & Yahoo - to the site)
```
// Create instance of the ApiFactory
$apiFactory = new \SeRanking\ApiFactory();

// Create a new Site entity
$site = new \SeRanking\Entities\Site();

// Set the sites attributes
$site->url               = 'www.thebloggers.com'; // required
$site->title             = 'The Bloggers'; // required
$site->depth             = 50; // optional (default: 100) - (50,100,150,200)
$site->subdomain_match   = 0; // optional (default: 0) - (0 or 1)
$site->exact_url         = 0; // optional (default: 0) - (0 or 1)
$site->manual_check_freq = 'check_daily'; // optional (default: check_daily) - ('check_daily','check_1in3','check_weekly','check_yandex_up','manual')
$site->auto_reports      = 0; // optional (default: 1) - (0 or 1)

// pass the site to the factory to create it. Method will return the SE Ranking site ID
$siteId = $apiFactory->createSite( $site );
```

## Update site
```
// Create instance of the ApiFactory
$apiFactory = new \SeRanking\ApiFactory();

// Instance a site entity passing the site id
$site = new \SeRanking\Entities\Site( SITE_ID );

// Change any parameters
$site->url  = 'www.newurl.com';

// Pass the site to the factory to update
$apiFactory->updateSite( $site );
```

## Get site stats
```
// Get the site entity passing the id
$site = new \SeRanking\Entities\Site( SITE_ID );

// define a date start and date end in the format "yyyy-mm-dd"
$dates = [
  'dateStart' => '2017-08-08',
  'dateEnd'   => '2017-08-08'
];

// Call getStats() passing the dates as a parameter
$stats = $site->getStats($dates);
```

## Add site keywords
```
// Instance the API factory
$apiFactory = new \SeRanking\ApiFactory();

// Create an array of keywords to add
$keywords = [
  'keyword1',
  'keyword2',
  'keyword3'
];

// Pass the keywords & a site id to the ApiFactory
$apiFactory->addSiteKeywords( SITE_ID, $keywords );
```

## Access site keywords
```
// Instance a Site entity by passing an ID
$site = new \SeRanking\Entities\Site( SITE_ID );

// Access the sites keywords with:
$site->keywords; // returns an array
```

## Delete keyword(s)
```
// Instance factory
$apiFactory = new \SeRanking\ApiFactory();

// Instance site
$site = new \SeRanking\Entities\Site( SITE_ID );

// Create array of keywords to delete (accessed by ID)
// You can find the id's of keywords attributed to the site with "$site->keywords"
$keywordsToDelete = [
  '1',
  '2'
];

// Call the factory to delete keywords
$apiFactory->destroySiteKeywords( $site->id, $keywordsToDelete );
``` 

## Common API functions
There are some useful API calls that are not site specific. These can all be accessed from the ApiFactory class.
```
// Returns a list of regions and there ID for avg.search volume
$apiFactory->searchVolumeRegions();

// Returns avg.search volume for a specified region and a keyword.
$apiFactory->searchVolumeRegions( $regionId, $keyword );

// Returns a list of all the search engines in an array of all possible regions (for Yandex).
$apiFactory->searchEngines();

// Returns full list of available languages for google search engines as key=>value (code=>full name) list. This method does not require any parameters
$apiFactory->getGoogleLangs();

```
