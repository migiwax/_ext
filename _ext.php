/** 
 * @fn extension function
 */
class _ext
{
  /**
   * @fn make dir
   * @brief Make if there is no directory.
   * @param[in] $dir dir path
   * @param[in] $permission permission (default = 755)
   * @return boolern
   * @remark extension mkdir().
   */
  public static function mkdir($dir,
                               $permission = 0755)
  {
    if (!is_dir($dir))
    {
      // Get Parent Dir.
      $parent_dir = dirname($dir);

      // Examine the parent
      if (!is_dir($parent_dir))
      {
        // [Recursion] Create retroactively.
        self::mkdir($parent_dir);
      }

      // mkDir
      if (!is_dir($dir))
      {
        mkdir($dir, $permission);
      }

      return true;
    }
    else
    {
      return false;  // Already.
    }
  }

  /**
   * @fn remove dir
   * @brief Also include child directory.
   * @param[in] $dir dir path
   * @return boolern
   * @remark extension rmdir().
   */
  public static function rmdir($dir)
  {
    if ($dh = opendir($dir))
    {
      while (false !== ($file = readdir($dh)))
      {
        // Execpt '.', '..'
        if (!in_array($file, array('.', '..')))
        {
          if (is_dir("$dir/$file"))
          {
            // [Recursion] Examine the children.
            self::rmdir("$dir/$file");
          }
          else
          {
            // Delete file.
            unlink("$dir/$file");
          }
        }
      }

      // opendir()
      closedir($dh);

      if (is_dir($dir))
      {
        rmdir($dir);
      }
    }

    return true;
  }

  /**
   * @fn scan dir
   * @brief List files and directories inside the specified path.
   *        Data is empty, return empty.
   * @param[in] $dir dir path
   * @return array
   * @remark extension scandir().
   */
  public static function scandir($dir)
  {
    $ret_dir = array();

    if (is_dir($dir))
    {
      $scan_dir = scandir($dir);
      
      if (!empty($scan_dir))
      {
        foreach ($scan_dir as $value)
        {
          // Execpt '.', '..'
          if (!in_array($value, array('.', '..')))
          {
            $ret_dir[] = $value;
          }
        }
      }
    }

    return $ret_dir;
  }
}
