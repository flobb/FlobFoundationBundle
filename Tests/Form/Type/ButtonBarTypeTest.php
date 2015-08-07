<?php

namespace Flob\Bundle\FoundationBundle\Tests\Form\Type;

use Flob\Bundle\FoundationBundle\Form\Type\ButtonBarType;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;

class ButtonBarTypeTest extends BaseTestCase
{
    /**
     * @var ButtonBarType
     */
    private $type;

    public function setUp()
    {
        $this->type = new ButtonBarType();
    }

    public function tearDown()
    {
        $this->type = null;
    }

    public function testGetName()
    {
        $this->assertEquals('button_bar', $this->type->getName());
    }

    public function testSetDefaultOptions()
    {
        $optionsResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolver');
        $optionsResolver->setDefaults(['button_groups' => [], 'options' => [], 'mapped' => false])->shouldBeCalled();

        $this->type->configureOptions($optionsResolver->reveal());
    }
}
