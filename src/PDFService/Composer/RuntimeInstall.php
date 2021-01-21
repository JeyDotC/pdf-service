<?php


namespace PDFService\Composer;


class RuntimeInstall
{
    private static $runtimeByOS = [
        'Windows' => 'https://github.com/wemersonjanuario/wkhtmltopdf-windows/raw/master/bin/wkhtmltopdf64.exe',
        'BSD' => 'https://github.com/profburial/wkhtmltopdf-binaries-trusty/raw/master/bin/wkhtmltopdf-linux-trusty-amd64',
        'OSX' => 'https://github.com/profburial/wkhtmltopdf-binaries-osx/raw/master/bin/wkhtmltoimage-amd64-osx',
        'Solaris' => 'https://github.com/profburial/wkhtmltopdf-binaries-trusty/raw/master/bin/wkhtmltopdf-linux-trusty-amd64',
        'Linux' => 'https://github.com/profburial/wkhtmltopdf-binaries-trusty/raw/master/bin/wkhtmltopdf-linux-trusty-amd64',
        'Unknown' => 'https://github.com/profburial/wkhtmltopdf-binaries-trusty/raw/master/bin/wkhtmltopdf-linux-trusty-amd64',
    ];

    public static function installRuntime(){
        $extension = PHP_OS_FAMILY === "Windows" ? '.exe' : '';
        $runtimeFileName = "./vendor/bin/wkhtmltopdf{$extension}";
        $runtimePackage = self::$runtimeByOS[PHP_OS_FAMILY];

        if(!is_file($runtimeFileName)) {
            echo "Downloading WKHTMLTOPDF runtime for " . PHP_OS_FAMILY . "...";
            $packageContents = file_get_contents($runtimePackage);
            echo "\nCopying to bin...";
            file_put_contents($runtimeFileName, $packageContents);
        }else{
            echo "\nPackage already installed.";
        }

        echo "\nDONE.";
    }
}