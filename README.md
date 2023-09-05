This is a PoC to prove that the remote side-loading of fonts doesn't work as it should. The helpers are constructing an url and malforming url's that are case sensitive. Url's can be case sensitive, as per spec, and the internal handling of the files shoudn't affect how the file get's downloaded in the first place.

Here we generate two files with the same font. One has the original source from Google Fonts and the other self-hosted via Github.

# Getting started

1. Run `composer install`.
2. Run `php index.php`
3. Observe `working.html.pdf` and `non-working.html.pdf`

# Additional info

I did a dirty dump on info to strengthen my case.

1. Put `var_dump($valid_sources);` on `vendor/dompdf/dompdf/src/Css/Stylesheet.php:L1478`
   * This will help you observe how `Helpers::build_url()` on `vendor/dompdf/dompdf/src/Css/Stylesheet.php:L1466` has already manipulated the source url to a lower-case version. This fails the download as Google will not serve the font like that.
2. Put `var_dump($localTempFile);` on `vendor/dompdf/dompdf/src/FontMetrics.php:L235`
   * This will confirm how the working version gets downloaded no problemo while the url with mixed lower-and-upper case will never get handled.

Relevant issue and specific [comment](https://github.com/dompdf/dompdf/issues/3142#issuecomment-1655712609) made about this.


