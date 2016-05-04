<?php

namespace Flob\Bundle\FoundationBundle\Tests\Form\Type;

use Flob\Bundle\FoundationBundle\Form\Type\SliderType;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;

class SliderTypeTest extends BaseTestCase
{
    /**
     * @var SliderType
     */
    private $type;

    public function setUp()
    {
        $this->type = new SliderType();
    }

    public function tearDown()
    {
        $this->type = null;
    }

    public function testGetParent()
    {
        $this->assertEquals('Symfony\Component\Form\Extension\Core\Type\NumberType', $this->type->getParent());
    }

    public function testSetDefaultOptions()
    {
        $optionsResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolver');
        $optionsResolver
            ->setRequired(['start', 'end', 'step', 'vertical'])
            ->shouldBeCalled()
        ;
        $optionsResolver
            ->setDefaults(['start' => 0, 'end' => 100, 'step' => 1, 'vertical' => false])
            ->shouldBeCalled()
        ;

        $this->type->configureOptions($optionsResolver->reveal());
    }
}
