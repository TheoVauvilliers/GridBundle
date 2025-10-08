<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as SymfonyDenormalizerInterface;
use TheoVauvilliers\GridBundle\Serializer\DenormalizerInterface;
use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use TheoVauvilliers\GridBundle\Entity\GridDefinitionColumn;
use TheoVauvilliers\GridBundle\Serializer\GridDefinitionDenormalizer;

class GridDefinitionDenormalizerTest extends TestCase
{
    protected GridDefinitionDenormalizer $denormalizer;
    protected SymfonyDenormalizerInterface $symfonyDenormalizer;

    protected function setUp(): void
    {
        $this->symfonyDenormalizer = $this->createMock(SymfonyDenormalizerInterface::class);
        $this->denormalizer = new GridDefinitionDenormalizer($this->symfonyDenormalizer);
    }

    public function testDenormalizeReturnsGridDefinition(): void
    {
        $data = [
            'name' => 'test_grid',
            'label' => 'Test Grid',
        ];

        $expectedGridDefinition = new GridDefinition();
        $expectedGridDefinition->setName('test_grid');
        $expectedGridDefinition->setLabel('Test Grid');

        $this->symfonyDenormalizer
            ->expects($this->once())
            ->method('denormalize')
            ->with($data, GridDefinition::class)
            ->willReturn($expectedGridDefinition);

        $result = $this->denormalizer->denormalize($data);

        $this->assertInstanceOf(GridDefinition::class, $result);
        $this->assertSame($expectedGridDefinition, $result);
    }

    public function testDenormalizeThrowsExceptionWhenResultIsNotGridDefinition(): void
    {
        $data = ['name' => 'test_grid'];

        $wrongObject = new \stdClass();

        $this->symfonyDenormalizer
            ->expects($this->once())
            ->method('denormalize')
            ->with($data, GridDefinition::class)
            ->willReturn($wrongObject);

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage(\sprintf(DenormalizerInterface::DENORMALIZED_FAILED, GridDefinition::class));

        $this->denormalizer->denormalize($data);
    }

    public function testDenormalizeWithEmptyData(): void
    {
        $data = [];

        $gridDefinition = new GridDefinition();

        $this->symfonyDenormalizer
            ->expects($this->once())
            ->method('denormalize')
            ->with($data, GridDefinition::class)
            ->willReturn($gridDefinition);

        $result = $this->denormalizer->denormalize($data);

        $this->assertInstanceOf(GridDefinition::class, $result);
    }

    public function testDenormalizeWithCompleteData(): void
    {
        $data = [
            'name' => 'users_grid',
            'label' => 'Users List',
            'source' => [
                'select' => [
                    [
                        'name' => 'id',
                        'alias' => 'id',
                    ],
                    [
                        'name' => 'name',
                        'alias' => 'name',
                    ],
                ],
                'from' => [
                    'entity' => 'App\Entity\User',
                    'alias' => 'u',
                ],
            ],
            'columns' => [
                [
                    'name' => 'id',
                    'label' => 'ID',
                    'type' => 'string',
                ],
                [
                    'name' => 'name',
                    'label' => 'name',
                    'type' => 'string',
                ],
            ],
            'actions' => [],
        ];

        $gridDefinition = new GridDefinition();
        $gridDefinition->setName('users_grid');
        $gridDefinition->setLabel('Users List');
        $gridDefinition->setColumns([
            new GridDefinitionColumn()->setName('id')->setLabel('ID')->setType('string'),
        ]);

        $this->symfonyDenormalizer
            ->expects($this->once())
            ->method('denormalize')
            ->with($data, GridDefinition::class)
            ->willReturn($gridDefinition);

        $result = $this->denormalizer->denormalize($data);

        $this->assertInstanceOf(GridDefinition::class, $result);
        $this->assertSame('users_grid', $result->getName());
        $this->assertSame('Users List', $result->getLabel());
        $this->assertSame('ID', $result->getColumns()[0]->getLabel());
    }
}
