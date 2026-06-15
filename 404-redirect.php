<?php
/**
 * 404 → Homepage redirect handler
 * Place this file at the ROOT of your project (same level as .htaccess)
 *
 * Sends a proper 301 redirect to homepage when any unmatched URL is hit.
 */

header("HTTP/1.1 301 Moved Permanently");
header("Location: https://lazurelighting.com");
exit;
