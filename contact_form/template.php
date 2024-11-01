<?php

class Template
{
    var $vars = array();
    var $path = './contact_form/template/';

    function Template($path = null)
    {
        if ($path) $this->set_path($path);
    }

    function set_path($path)
    {
        $this->path = rtrim($path, '/') . '/';
    }

    function get_path()
    {
        return $this->path;
    }

    function assign($name, $value)
    {
        if (is_string($name)) $this->vars[$name] = $value;
    }

    function append($name, $value)
    {
        if (is_string($name)) {
            if (!isset($this->vars[$name]) || !is_array($this->vars[$name])) {
                $this->vars[$name] = array();
            }
            $this->vars[$name] = array_merge($this->vars[$name], (array)$value);
        }
    }

    function fetch($file)
    {
        $file_path = $this->path . $file;
        if (!file_exists($file_path)) return "Error: Template file '{$file}' not found.";

        extract($this->vars, EXTR_SKIP);
        ob_start();
        include($file_path);
        return ob_get_clean();
    }

    function display($file)
    {
        echo $this->fetch($file);
    }
}

//  テンプレートの自動キャッシュ機能を提供するTemplateの拡張
class CachedTemplate extends Template
{
    var $cache_id;
    var $expire;
    var $cached;

    function CachedTemplate($path, $cache_id = null, $expire = 900)
    {
        $this->Template($path);
        $this->set_cache_id($cache_id);
        $this->expire = max(0, (int)$expire);
    }

    function set_cache_id($cache_id)
    {
        $this->cache_id = $cache_id ? 'cache/' . md5($cache_id) : null;
    }

    function is_cached()
    {
        if ($this->cached) return true;
        if (!$this->cache_id || !file_exists($this->cache_id)) return false;

        $mtime = @filemtime($this->cache_id);
        if ($mtime === false || ($mtime + $this->expire) < time()) {
            @unlink($this->cache_id);
            return false;
        }

        $this->cached = true;
        return true;
    }

    function fetch_cache($file)
    {
        if ($this->is_cached()) {
            $contents = @file_get_contents($this->cache_id);
            if ($contents !== false) return $contents;
        }

        $contents = $this->fetch($file);

        if ($this->cache_id && @file_put_contents($this->cache_id, $contents, LOCK_EX) === false) {
            error_log("Unable to write cache file: {$this->cache_id}");
        }

        return $contents;
    }
}
