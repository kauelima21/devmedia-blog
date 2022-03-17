<?php

/**
 * Carrega css e js
 *
 * @param string $path
 * @return string
 */
function loadAsset(string $path): string {
    return "http://localhost/devmedia-blog/public/assets" . (substr($path, 0) == "/" ? $path : "/" . $path);
}

/**
 * Carrega links do site
 *
 * @param string $path
 * @return string
 */
function url(string $path): string {
    return "http://localhost/devmedia-blog" . (substr($path, 0) == "/" ? $path : "/" . $path);
}
