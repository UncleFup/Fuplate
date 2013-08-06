# Rewrites
* Please see https://github.com/retlehs/roots/blob/master/doc/rewrites.md

> Rewrites currently do not happen for child themes or network installs.
>
> Rewrite:
>
> /wp-content/themes/themename/assets/css/ to /assets/css/
> /wp-content/themes/themename/assets/js/ to /assets/js/
> /wp-content/themes/themename/assets/img/ to /assets/img/
> /wp-content/plugins/ -> /plugins/

In Apache, rewrites should work "automagically" provided you are using "%permalinks%" for
the permalink structure. Perhaps later, will look at making this work elsewhere.

## For Nginx
> Include these in your Nginx config, before the PHP fastcgi block (location ~ \.php$).
>
>` location ~ ^/assets/(img|js|css)/(.*)$ {`
>`   try_files $uri $uri/ /wp-content/themes/roots/assets/$1/$2;`
>` }`
>` location ~ ^/plugins/(.*)$ {`
>`  try_files $uri $uri/ /wp-content/plugins/$1;`
>` }`

## For Lighttpd

> url.rewrite-once = (`
> `  "^/css/(.*)$" => "/wp-content/themes/roots/css/$1",`
> `  "^/js/(.*)$" => "/wp-content/themes/roots/js/$1",`
> `  "^/img/(.*)$" => "/wp-content/themes/roots/img/$1",`
> `  "^/plugins/(.*)$" => "/wp-content/plugins/$1"`
> `)`