<?php

namespace Flob\Bundle\FoundationBundle\Tests;

use Prophecy\Prophet;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophecy\Prophet
     */
    private $prophet = null;

    /**
     * {@inheritdoc}
     */
    protected function verifyMockObjects()
    {
        parent::verifyMockObjects();

        if ($this->prophet !== null) {
            try {
                $this->prophet->checkPredictions();
            } catch (\Exception $e) {
                /* Intentionally left empty */
            }
            foreach ($this->prophet->getProphecies() as $objectProphecy) {
                foreach ($objectProphecy->getMethodProphecies() as $methodProphecies) {
                    foreach ($methodProphecies as $methodProphecy) {
                        $this->addToAssertionCount(count($methodProphecy->getCheckedPredictions()));
                    }
                }
            }
            if (isset($e)) {
                throw $e;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function runBare()
    {
        parent::runBare();

        $this->prophet = null;
    }

    /**
     * @param string|null $classOrInterface
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     *
     * @throws \LogicException
     */
    protected function prophesize($classOrInterface = null)
    {
        return $this->getProphet()->prophesize($classOrInterface);
    }

    /**
     * @return Prophecy\Prophet
     */
    private function getProphet()
    {
        if ($this->prophet === null) {
            $this->prophet = new Prophet();
        }

        return $this->prophet;
    }
}
