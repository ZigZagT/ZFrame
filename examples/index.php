<?php
/*
 * Copyright 2015 master.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
defined('_ZEXEC') or define("_ZEXEC", 1);
require_once 'base.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Examples</title>
    </head>
    <body>
        <h2>All Available Examples:</h2>
        <?php
        $part = explode('/index.php', $_SERVER['SCRIPT_FILENAME']);
        $parentName = $part[0];
        $iterator = new DirectoryIterator($parentName);
        foreach ($iterator as $file) {
            $fileName = $file->getFileName();
            if (($file->isFile() || $file->isLink()) && $fileName[0] != '.' && $fileName != 'index.php') {
                $filePath = explode('index.php', $_SERVER['SCRIPT_NAME'])[0] . $fileName;
                ?>
                <p><a href="<?php echo $filePath; ?>"><?php echo $fileName; ?></a></p>
                <?php
            }
        }
        ?>
    </body>
</html>
