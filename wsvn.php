<?php

// WebSVN - Subversion repository viewing via the web using PHP
// Copyright (C) 2004 Tim Armes
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// --
//

// Configure these variable...

// Location of websvn directory via HTTP
$locwebsvnhttp = "/websvn";  

// Physical of websvn directory
$locwebsvnreal = "d:/websvn";

ini_set("include_path", $locwebsvnreal);

// --- DON'T CHANGE BELOW HERE ---

require("include/config.inc");
require("include/svnlook.inc");

if (!isset($_REQUEST["sc"]))
   $_REQUEST["sc"] = 1;

if ($config->multiViews)
{
   $path = @$_SERVER["PATH_INFO"];

   // Remove initial slash
   $path = substr($path, 1);
   if (empty($path))
   {
      include("$locwebsvnreal/index.php");
      exit;
   }
   
   // Get the repository name
   $pos = strpos($path, "/");
   $name = substr($path, 0, $pos);
   
   // Get the path within the repository
   $_REQUEST["path"] = substr($path, $pos + 1);
   $_REQUEST["rep"] = $config->findRepository($name);
   
   // find the operation type
   $op = @$_REQUEST["op"];
   switch ($op)
   {
      case "dir":
         $file = "listing.php";
         break;
         
      case "file":
         $file = "filedetails.php";
         break;

      case "log":
         $file = "log.php";
         break;

      case "diff":
         $file = "diff.php";
         break;

      default:
         $file = "listing.php";
   }
   
   // Now include the file that handles it
   include("$locwebsvnreal/$file");
}