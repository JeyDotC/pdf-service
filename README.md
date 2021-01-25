# PDF Renderer Service

```php
<?php
use \PDFService\Core\PDFRenderService;
use \PDFService\TemplateRepositories\FileSystemTemplatesRepository;
use \PDFService\TemplateEngines\RawTemplateEngine;
use \PDFService\PDFRenderers\SnappyPDFRenderer;
use \PDFService\BinStorages\FileSystemBinStorage;
use \PDFService\Core\RenderRequest;

// Setup the service, preferably at DI config:
$rendererService = PDFRenderService::create()
   ->setTemplatesRepository(new FileSystemTemplatesRepository("/path/to/templates"))
   ->setTemplateEngine(new RawTemplateEngine(sys_get_temp_dir()))
   ->setPdfRenderer(new SnappyPDFRenderer())
   ->setBinStorage(new FileSystemBinStorage("/path/to/storage/folder"));

// Render your PDF.   
$rendererService->renderPDF(new RenderRequest("my-template.php", [ 'my' => 'data' ]));
```

## Introduction

This library is intended to provide a simple and configurable pipeline for rendering PDFs.

The main idea is to render a PDF using this process:

0. Receive some data.
1. Get a template.
2. Render the template feeding it with the received data.
3. Generate the PDF from the rendered data.
4. Store the PDF somewhere.

Those are the 5 key aspects of rendering a PDF and they're all managed by this class:

> `PDFService\Core\PDFRenderService`

The magic comes with the fact that, you can just configure all of these aspects with whatever suites your needs:

1. Get a template.
    * Get it from file system (only implementation so far, and also the default).
    * Or get from a database.
    * Or get it from an external service.
    * Or just implement `ITemplatesRepository` and call `->setTemplatesRepository()`
2. Render the template feeding it with the received data.
    * Using Raw PHP (default).
    * Or just implement `ITemplateEngine` and call `->setTemplateEngine()` to adapt your favorite template engine.
3. Generate the PDF from the rendered data.
    * Using wkhtmltopdf (only implementation so far, and also the default).
    * Or DOMPdf
    * Or whatever thing that can convert HTML to PDF, just implement `IPDFRenderer` and call `->setPdfRenderer()`.
4. Store the PDF somewhere.
    * Just return the data (default).
    * Or store it in the file system (also implemented).
    * Or send it to an external service (db, storage, etc.).
    * Just implement `IBinStorage` and call `->setBinStorage()`.

## How to install

```shell
composer require jeydotc/pdf-service
```

## Setup the `wkhtmltopdf` binary required by `SnappyPDFRenderer`

The default `SnappyPDFRenderer` requires a `wkhtmltopdf` binary to work, there are several options to configure it:

### Option 1: Download it yourself

Just download an adequate binary for your system and copy it to your `./vendor/bin` folder. Or put it anywhere and give the absolute path to the constructor.

### Option 2: Use the post-install-cmd

In your `composer.json` file, add this snipped under the "scripts" section:

```json
{
   // The rest of your composer file....
   "scripts": { //<-- Add this if not already existing.
      "post-install-cmd": [ //<-- Add this if not already existing. 
         "PDFService\\Composer\\RuntimeInstall::installRuntime" //<-- Add this array entry.
      ]
   },
}
```

Then run `composer install`. This will attempt to download the appropriate binary depending on your system. Currently, the only supported ones are:

* MacOS-x64      
* Ubuntu-16-AMD64
* Ubuntu-18-AMD64
* Ubuntu-20-AMD64
* Windows-x64

If your system is not in the above list, you can still run your composer install like this:

`PDF_SERVICE_URL=<url-to-wkhtmltopdf-binary> composer install`

Where `<url-to-wkhtmltopdf-binary>` can be either a URL to download the binary or an absolute path to a `wkhtmltopdf` file in your local machine.

## How to use

Create and save a template somewhere:

_My-Raw-Template.php_

```php
<?php
return function($data){?>
    <html>
        <head>
            <style>
                h1 { color: #9999FF; }
            </style>
        </head>
        <body>
            <h1>Hello $data['name']</h1>
        </body>
    </html>
<?php };
```

Create and configure an instance of `PDFREndererService`:

```php
$service = PDFRenderService::create()
                    ->setTemplatesRepository(new FileSystemTemplatesRepository('/the/directory/where-templates/are/located'));
```

Call the renderPDF method and get the results:

```php
$result = $service->renderPDF(new RenderRequest('My-Raw-Template.php', [ 'name' => 'Joe' ]));
```

In this case, the results will be the PDF data returned as a string, which you can either store somewhere or return to
the user.

To make the service generate a file, all you need to do is to set a bin storage, to do so, before calling the render
method, just call `setBinStorage`:

```php
$service = PDFRenderService::create()
                    ->setTemplatesRepository(new FileSystemTemplatesRepository('/the/directory/where-templates/are/located'))
                    ->setBinStorage(new FileSystemBinStorage('/place/to-put/pdfs/into'));

$result = $service->renderPDF(new RenderRequest('My-Raw-Template.php', [ 'name' => 'Joe' ]));
```

This will save the PDF in the given directory and return the file name.

The name will be generated by joining the template name, the md5 hash of the resulting pdf and the time, like this:

`{templateName}-{dataMD5}-{time()}.pdf`

Example:

`My-Raw-Template.php-2de85b56ded9694eb5100349480d980b-1550007643.pdf`

To change that behavior, just send a callable as the second parameter of the storage constructor:

```php
$service = PDFRenderService::create()
                    ->setTemplatesRepository(new FileSystemTemplatesRepository('/the/directory/where-templates/are/located'))
                    ->setBinStorage(new FileSystemBinStorage('/place/to-put/pdfs/into', function(RenderRequest $request, $pdfData){
                        return 'I-Like-Turtles.pdf';
                    }));

$result = $service->renderPDF(new RenderRequest('My-Raw-Template.php', [ 'name' => 'Joe' ]));
```

> TODO: Send some extra info in the $request class?