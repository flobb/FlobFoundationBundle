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

    public function testGetParent()
    {
        $this->assertEquals('Symfony\Component\Form\Extension\Core\Type\ChoiceType', $this->type->getParent());
    }

    public function testSetDefaultOptions()
    {
        $optionsResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolver');
        $optionsResolver
            ->setDefaults(['expanded' => true])
            ->shouldBeCalled()
        ;

        $this->type->configureOptions($optionsResolver->reveal());
    }
}
