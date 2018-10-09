# drupal8-module

After enabling the module in Drupal version 8.6.1. One can find a new field in the system site information form which is in the URL <strong>BASE_URL/admin/config/system/site-information</strong>. Where one can set the "Site API Key".

It provides an URL, <strong>BASE_URL/page_json/{siteapikey}/{nid}</strong> which returns the provided node object of type page in json format. The {siteapikey} is the key that one has set in the system site information form mentioned above and {nid} is the node ID of node type "page".
