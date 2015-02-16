<?php

namespace Flob\Bundle\FoundationBundle\Tests\Form\Type;

use Flob\Bundle\FoundationBundle\Form\Type\ButtonGroupType;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;

class ButtonGroupTypeTest extends BaseTestCase
{
    /**
     * @var ButtonGroupType
     */
    private $type;

    public function setUp()
    {
        $this->type = new ButtonGroupType();
    }

    public function tearDown()
    {
        $this->type = null;
    }

    public function testGetName()
    {
        $this->assertEquals('button_group', $this->type->getName());
    }

    public function testSetDefaultOptions()
    {
        $optionsResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolverInterface');
        $optionsResolver->setDefaults(array('buttons' => array(), 'options' => array(), 'mapped' => false))->shouldBeCalled();

        $this->type->setDefaultOptions($optionsResolver->reveal());
    }
}
