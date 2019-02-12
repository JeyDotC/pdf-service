Common usage:

```php
// Create an instance.
$service = PDFRenderService::create()
        // Use Twig template engine, default is Raw
        ->using(Twig::create())
        ->using(FileSystem::create()
                    // Use the file system to get the templates and tell where the templates are.
                    ->forTemplatesStorage(__DIR__)
                    // Use the file system to store the resulting PDF and tell where to do it. Default would just return the PDF as a string.
                    ->forBinStorage(__DIR__)
                );

// Do the magic...
$renderRequest = new RenderRequest('test-data.html', []);

// And get the results. In this case, the generated file name under the given folder. TODO: Add the possibility to decide how are PDF names generated.
$result = $service->renderPDF($renderRequest);
```