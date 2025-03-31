<?php

namespace JDZ\Utils;

/**
 * @author  Joffrey Demetz <joffrey.demetz@gmail.com>
 */
class Dump
{
  private string $filePath;

  public function __construct(string $filePath)
  {
    $this->filePath = $filePath;
  }

  public function exists(): bool
  {
    return \file_exists($this->filePath);
  }

  public function write(string $str)
  {
    $str = trim($str) . "\n";
    \file_put_contents($this->filePath, $str, \FILE_APPEND);
    return $this;
  }

  public function read(): ?string
  {
    if (false === $this->exists()) {
      return null;
    }
    return \file_get_contents($this->filePath);
  }

  public function delete()
  {
    if (true === $this->exists()) {
      unlink($this->filePath);
    }
    return $this;
  }
}
