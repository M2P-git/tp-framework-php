<?php
// Copie de lecture pour l'IDE Windows. L'application utilise toujours /app/vendor.
$source = dirname(__DIR__).'/vendor';
$destination = dirname(__DIR__).'/.ide-vendor';
if (!is_dir($source)) { fwrite(STDERR, "Installer d'abord Composer.\n"); exit(1); }
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS));
$count = 0;
foreach ($files as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') { continue; }
    $relative = substr($file->getPathname(), strlen($source) + 1);
    $target = $destination.'/'.$relative;
    if (!is_dir(dirname($target))) { mkdir(dirname($target), 0777, true); }
    if (!copy($file->getPathname(), $target)) { throw new RuntimeException('Copie IDE impossible'); }
    $count++;
}
echo "Cache IDE : $count fichiers PHP. Ne pas modifier cette copie.\n";
