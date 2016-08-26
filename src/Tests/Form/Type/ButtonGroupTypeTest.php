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

    public function testSetDefaultOptions()
    {
        $optionsResolver = $this->prophesize('Symfony\Component\OptionsResolver\OptionsResolver');
        $optionsResolver
            ->setDefaults(['buttons' => [], 'options' => [], 'mapped' => false])
            ->shouldBeCalled()
        ;

        $this->type->configureOptions($optionsResolver->reveal());
    }
}
