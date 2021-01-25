<?php


namespace PDFService\Composer;


class RuntimeInstall
{
    private static $runtimeByOS = [
        'MacOS-x64' => 'https://github.com/JeyDotC/wkhtmltopdf-bins/raw/master/0.12.6-macos-x64/wkhtmltopdf',
        'Ubuntu-16-AMD64' => 'https://github.com/JeyDotC/wkhtmltopdf-bins/raw/master/0.12.6-ubuntu-16-amd64/wkhtmltopdf',
        'Ubuntu-18-AMD64' => 'https://github.com/JeyDotC/wkhtmltopdf-bins/raw/master/0.12.6-ubuntu-18-amd64/wkhtmltopdf',
        'Ubuntu-20-AMD64' => 'https://github.com/JeyDotC/wkhtmltopdf-bins/raw/master/0.12.6-ubuntu-20-amd64/wkhtmltopdf',
        'Windows-x64' => 'https://github.com/JeyDotC/wkhtmltopdf-bins/raw/master/0.12.6-windows-x64/wkhtmltopdf.exe',
    ];

    private static function byEnvKey()
    {
        if (isset($_ENV['PDF_SERVICE_SYSTEM']) && !empty($_ENV['PDF_SERVICE_SYSTEM'])) {
            $key = $_ENV['PDF_SERVICE_SYSTEM'];
            return self::$runtimeByOS[$key];
        }

        return null;
    }

    private static function byEnvUrl()
    {
        if (isset($_ENV['PDF_SERVICE_URL']) && !empty($_ENV['PDF_SERVICE_URL'])) {
            return $_ENV['PDF_SERVICE_URL'];
        }

        return null;
    }

    private static function byCalculatedKey()
    {
        // Check for Windows:
        if (PHP_OS_FAMILY === "Windows") {
            return self::$runtimeByOS['Windows-x64'];
        }

        // Check for MacOS
        if (PHP_OS_FAMILY === 'Darwin') {
            return self::$runtimeByOS['MacOS-x64'];
        }

        $distro = shell_exec('lsb_release -si');
        $version = shell_exec('lsb_release -sr');
        $versionMajor = (int)$version;

        if ($distro !== 'Ubuntu' || !in_array((int)$versionMajor, [16, 18, 20])) {
            throw new \Exception("System [$distro-$version] Not Supported by this Script. However, you can always download your own wkhtmltopdf binary and put it under ./vendor/bin directory, or call composer install like this: `PDF_SERVICE_URL=<url-to-wkhtmltopdf-binary> composer install`");
        }

        return self::$runtimeByOS["Ubuntu-$versionMajor-AMD64"];
    }

    public static function installRuntime()
    {
        $extension = PHP_OS_FAMILY === "Windows" ? '.exe' : '';
        $runtimeFileName = "./vendor/bin/wkhtmltopdf{$extension}";
        $runtimePackage = self::byEnvKey() ?? self::byEnvUrl() ?? self::byCalculatedKey();

        if (!is_file($runtimeFileName)) {
            echo "Downloading WKHTMLTOPDF runtime for " . PHP_OS_FAMILY . "...\n";
            echo "\nResolved URL: {$runtimePackage}";
            $packageContents = file_get_contents($runtimePackage);
            echo "\nCopying to bin...";
            file_put_contents($runtimeFileName, $packageContents);
        } else {
            echo "\nPackage already installed.";
        }

        echo "\nDONE.";
    }
}