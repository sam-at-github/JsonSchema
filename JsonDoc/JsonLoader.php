<?php
namespace JsonDoc;

/**
 * Shim interface to alow client to control loading.
 * Loads what shoudl be a raw JSON doc given a URI.
 * Default implementation supports loading from URIs point to file, http, and ftp.
 */
class JsonLoader
{
  /**
   * Load raw data from $uri. The data should be decodable.
   * @throws ResourceNotFoundException.
   */
  public function load($uri) {
    return file_get_contents($uri);
  }
}