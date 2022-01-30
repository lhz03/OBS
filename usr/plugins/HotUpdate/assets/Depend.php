<?php

function t(){
    return 'ok';
}
require_once __DIR__ . '/Uncompress.php';
/**
 * 下载文件
 * @param string $url 要下载的文件地址
 * @param array $path 要保存的路径
 * @return object
 */
function downloadFile($url, $path)
{
    mkdir('../down',0777,true);
	$newfname = $path;
	$file = fopen($url, 'rb');
	if ($file) {
		$newf = fopen($newfname, 'wb');
		if ($newf) {
			while (!feof($file)) {
				fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
			}
		}
	}
	if ($file) {
		fclose($file);
	}
	if ($newf) {
		fclose($newf);
	}
	return true;
}

function recurse_copy($src, $dst)
{ // 原目录，复bai制到的目du录
	$dir = opendir($src);
	@mkdir($dst);
	while (false !== ($file = readdir($dir))) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				recurse_copy($src . '/' . $file, $dst . '/' . $file);
			} else {
				copy($src . '/' . $file, $dst . '/' . $file);
			}
		}
	}
	closedir($dir);
	return true;
}

//清空文件夹函数和清空文件夹后删除空文件夹函数的处理
function deldir($path)
{
	$dh = opendir($path);
	var_dump(readdir($dh));
	while (($d = readdir($dh)) !== false) {
		if ($d == '.' || $d == '..') { //如果为.或..
			continue;
		}
		$tmp = $path . '/' . $d;
		if (!is_dir($tmp)) { //如果为文件
			unlink($tmp);
		} else { //如果为目录
			deldir($tmp);
		}
	}
	closedir($dh);
	rmdir($path);
	return true;
}
