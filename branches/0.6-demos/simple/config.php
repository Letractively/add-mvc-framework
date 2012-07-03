<?php
/**
 * config file
 * @author albertdiones@gmail.com
 */

$C = (object) array(
      'add_dir'            => 'C:\\Users\\Reky nala\\Desktop\\add-mvc-framework\\branches\\0.6',
      'super_domain'       => preg_replace('/^www\./','',$_SERVER['HTTP_HOST']),
      'sub_domain'         => 'www',
      'path'               => preg_replace('/\/[^\/]*?$/','/',$_SERVER['REQUEST_URI']),
      'root_dir'           => realpath('./'),


      /**
       * Library init files
       * @author albertdiones@gmail.com
       */
      'libs'            => (object) array(
            'adodb'     => 'adodb/adodb.inc.php',
            'smarty'    => 'smarty/Smarty.class.php',
            'phpmailer' => 'phpmailer/class.phpmailer.php',
            'tclink' => 'tclink.php',
         ),
   );
