<?php

namespace PDFService\TemplateEngines;

use PDFService\Core\Template;
use PHPUnit\Framework\TestCase;

class RawTemplateEngineTest extends TestCase
{
    /**
     * @dataProvider rawTemplateProvider
     * @param $templateContents
     * @param $expectedHtml
     */
    public function testRawTemplate($templateContents, $expectedHtml){
        // Arrange
        $rawTemplateEngine = new RawTemplateEngine();

        // Act
        $renderedHtml = $rawTemplateEngine->renderTemplate(new Template('my-template.php', $templateContents, new \DateTime()), [
            'name' => 'John Doe',
        ]);

        // Assert
        self::assertEquals($expectedHtml, $renderedHtml, "Raw template engine should render the given template by calling the returned function.");
    }

    public function rawTemplateProvider(){
        yield 'Simple Callable template' => [
            '<?php return function ($data) {?><h1><?=$data["name"]?></h1><?php }?>',
            '<h1>John Doe</h1>',
        ];

        yield 'Simple Non-Callable template' => [
            '<h1><?=$data["name"]?></h1>',
            '<h1>John Doe</h1>',
        ];
    }
}
