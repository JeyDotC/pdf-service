
```php
$service = new PDFService\Core\PDFRenderService(
    ITemplatesRepository $templates, 
    ITemplateEngine $templateEngine, 
    IPDFRenderer $pdfRenderer, 
    IBinStorage $storage
);
```