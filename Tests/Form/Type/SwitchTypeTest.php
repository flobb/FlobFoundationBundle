<?php

namespace Flob\Bundle\FoundationBundle\Tests\Form\Type;

use Flob\Bundle\FoundationBundle\Form\Type\SwitchType;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;

class SwitchTypeTest extends BaseTestCase
{
    /**
     * @var SwitchType
     */
    private $type;

    public function setUp()
    {
        $this->type = new SwitchType();
    }

    public function tearDown()
    {
        $this->type = null;
    }

    public function testGetName()
    {
        $this->assertEquals('switch', $this->type->getName());
    }

    public function testGetParent()
    {
        $this->assertEquals('choice', $this->type->getParent());
    }

    public function testSetDefaultOptions()
    {
        $optionsResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolverInterface');
        $optionsResolver->setDefaults(array('expanded' => true))->shouldBeCalled();

        $this->type->setDefaultOptions($optionsResolver->reveal());
    }
}
