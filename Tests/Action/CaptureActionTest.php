<?php
namespace Payum\Paymill\Tests\Action;

use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\Request\Capture;
use Payum\Core\Tests\GenericActionTest;
use Payum\Paymill\Action\CaptureAction;

class CaptureActionTest extends GenericActionTest
{
    protected $actionClass = CaptureAction::class;

    protected $requestClass = Capture::class;

    /**
     * @test
     */
    public function shouldBeSubClassOfGatewayAwareAction()
    {
        $rc = new \ReflectionClass(CaptureAction::class);

        $this->assertTrue($rc->isSubclassOf(GatewayAwareAction::class));
    }
}
